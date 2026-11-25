<?php

namespace App\Http\Controllers;

use App\Models\KoordinasiDamkar;
use App\Models\LaporanKarhutla;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoordinasiDamkarController extends Controller
{
    /**
     * Menampilkan daftar permintaan koordinasi.
     * PBI-016 dan PBI-017.
     */
    public function index(Request $request)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['pusdalops', 'damkar'])) {
            abort(403, 'Akses ditolak.');
        }

        // Query dasar: Damkar hanya melihat permintaan miliknya sendiri.
        $dasar = KoordinasiDamkar::query();

        if (auth()->user()->role === 'damkar') {
            $dasar->where('petugas_damkar_id', auth()->id());
        }

        // Ringkasan untuk kartu statistik.
        $ringkasan = [
            'total' => (clone $dasar)->count(),
            'menunggu' => (clone $dasar)->where('status', 'Menunggu Konfirmasi')->count(),
            'diterima' => (clone $dasar)->where('status', 'Diterima')->count(),
            'ditolak' => (clone $dasar)->where('status', 'Ditolak')->count(),
        ];

        $query = (clone $dasar)->with([
            'laporan',
            'petugasDamkar',
            'petugasBpbd'
        ])->latest();

        // Filter status.
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Pencarian kode laporan, lokasi, atau nama petugas Damkar.
        if ($request->filled('q')) {
            $kata = $request->q;
            $query->where(function ($q) use ($kata) {
                $q->whereHas('laporan', function ($l) use ($kata) {
                    $l->where('kode_laporan', 'like', "%{$kata}%")
                      ->orWhere('lokasi', 'like', "%{$kata}%");
                })->orWhereHas('petugasDamkar', function ($u) use ($kata) {
                    $u->where('name', 'like', "%{$kata}%");
                });
            });
        }

        $koordinasi = $query->paginate(10)->withQueryString();

        return view('koordinasi-damkar.index', compact('koordinasi', 'ringkasan'));
    }

    /**
     * Menampilkan formulir pengiriman permintaan penanganan.
     * PBI-016.
     */
    public function create()
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak. Hanya Pusdalops yang dapat mengirim permintaan.');
        }

        $laporans = LaporanKarhutla::latest()->get();

        $petugasDamkar = User::where('role', 'damkar')
            ->orderBy('name')
            ->get();

        return view('koordinasi-damkar.create', compact(
            'laporans',
            'petugasDamkar'
        ));
    }

    /**
     * Menyimpan permintaan penanganan kepada Damkar.
     * PBI-016.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak. Hanya Pusdalops yang dapat mengirim permintaan.');
        }

        $validated = $request->validate([
            'laporan_karhutla_id' => 'required|exists:laporan_karhutla,id',

            'petugas_damkar_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $petugas = User::find($value);

                    if (!$petugas || $petugas->role !== 'damkar') {
                        $fail('Penerima harus merupakan petugas Damkar.');
                    }
                },
            ],

            'metode_komunikasi' => 'required|in:Telepon,WhatsApp,Radio',

            'catatan' => 'nullable|string|max:2000',
        ]);

        // Mengambil laporan yang dipilih.
        $laporan = LaporanKarhutla::findOrFail(
            $validated['laporan_karhutla_id']
        );

        // Menentukan tingkat risiko berdasarkan data laporan.
        $prioritas = match (trim((string) $laporan->tingkat_risiko)) {
            'Tinggi' => 'Tinggi',
            'Sedang' => 'Sedang',
            'Rendah' => 'Rendah',
            default => null,
        };

        // Memastikan laporan sudah memiliki tingkat risiko yang valid.
        if ($prioritas === null) {
            return back()
                ->withInput()
                ->withErrors([
                    'laporan_karhutla_id' =>
                        'Laporan belum memiliki tingkat risiko Tinggi, Sedang, atau Rendah. Lakukan penilaian risiko terlebih dahulu.'
                ]);
        }

        // Menyimpan permintaan dengan waktu koordinasi otomatis.
        DB::transaction(function () use ($validated, $prioritas) {
            KoordinasiDamkar::create([
                'laporan_karhutla_id' => $validated['laporan_karhutla_id'],
                'petugas_damkar_id' => $validated['petugas_damkar_id'],
                'bpbd_user_id' => auth()->id(),
                'metode_komunikasi' => $validated['metode_komunikasi'],
                'waktu_koordinasi' => now(),
                'prioritas' => $prioritas,
                'status' => 'Menunggu Konfirmasi',
                'catatan' => $validated['catatan'] ?? null,
            ]);
        });

        return redirect()
            ->route('koordinasi-damkar.index')
            ->with(
                'success',
                'Permintaan penanganan berhasil dikirim kepada petugas Damkar. Tingkat risiko: ' . $prioritas . '.'
            );
    }

    /**
     * Menampilkan detail permintaan penanganan.
     * PBI-018.
     */
    public function show($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'damkar') {
            abort(403, 'Akses ditolak. Hanya petugas Damkar yang dapat melihat detail permintaan.');
        }

        $koordinasi = KoordinasiDamkar::with([
            'laporan',
            'petugasDamkar',
            'petugasBpbd'
        ])
            ->where('id', $id)
            ->where('petugas_damkar_id', auth()->id())
            ->firstOrFail();

        return view('koordinasi-damkar.show', compact('koordinasi'));
    }

    /**
     * Memberikan konfirmasi dan menentukan tim penanganan.
     * PBI-018.
     */
    public function confirm(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'damkar') {
            abort(403, 'Akses ditolak. Hanya petugas Damkar yang dapat memberikan konfirmasi.');
        }

        $koordinasi = KoordinasiDamkar::where('id', $id)
            ->where('petugas_damkar_id', auth()->id())
            ->firstOrFail();

        // Permintaan hanya dapat dikonfirmasi satu kali.
        if (!in_array($koordinasi->status, ['Menunggu Konfirmasi', 'Terkirim'])) {
            return redirect()
                ->route('koordinasi-damkar.index')
                ->with('error', 'Permintaan ini sudah memiliki keputusan.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Diterima,Ditolak',
            'tim_ditugaskan' => 'required_if:status,Diterima|nullable|string|max:255',
            'catatan_konfirmasi' => 'required_if:status,Ditolak|nullable|string|max:2000',
        ], [
            'tim_ditugaskan.required_if' => 'Nama tim wajib diisi jika permintaan diterima.',
            'catatan_konfirmasi.required_if' => 'Alasan penolakan wajib diisi jika permintaan ditolak.',
        ]);

        DB::transaction(function () use ($koordinasi, $validated) {
            $koordinasi->update([
                'status' => $validated['status'],

                'tim_ditugaskan' => $validated['status'] === 'Diterima'
                    ? $validated['tim_ditugaskan']
                    : null,

                'waktu_konfirmasi' => now(),

                'catatan_konfirmasi' => $validated['catatan_konfirmasi'] ?? null,
            ]);
        });

        return redirect()
            ->route('koordinasi-damkar.index')
            ->with('success', 'Konfirmasi permintaan penanganan berhasil disimpan.');
    }
}
