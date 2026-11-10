
@php
    $role = auth()->user()->role ?? null;

    $menus = match ($role) {
        'pusdalops' => [
            ['label' => 'Dashboard', 'icon' => 'bi-speedometer2'],
            ['label' => 'Data Wilayah Karhutla', 'icon' => 'bi-geo-alt', 'route' => 'wilayah.index'],
            ['label' => 'Laporan Karhutla', 'icon' => 'bi-file-earmark-text'],
            ['label' => 'Verifikasi Laporan', 'icon' => 'bi-check-circle'],
            ['label' => 'Penilaian Risiko', 'icon' => 'bi-exclamation-triangle'],
            ['label' => 'Koordinasi Damkar', 'icon' => 'bi-people'],
            ['label' => 'Monitoring Penanganan', 'icon' => 'bi-activity'],
            ['label' => 'Peta Persebaran', 'icon' => 'bi-map'],
            ['label' => 'Rekapitulasi Kejadian', 'icon' => 'bi-bar-chart'],
        ],
        'damkar' => [
            ['label' => 'Dashboard', 'icon' => 'bi-speedometer2'],
            ['label' => 'Tugas Penanganan', 'icon' => 'bi-clipboard-check'],
            ['label' => 'Update Status Penanganan', 'icon' => 'bi-arrow-repeat'],
            ['label' => 'Hasil Penanganan', 'icon' => 'bi-file-check'],
        ],
        'rr' => [
            ['label' => 'Dashboard', 'icon' => 'bi-speedometer2'],
            ['label' => 'Data Kerusakan Lahan', 'icon' => 'bi-tree'],
            ['label' => 'Rehabilitasi Lahan', 'icon' => 'bi-flower1'],
            ['label' => 'Peta Persebaran', 'icon' => 'bi-map'],
        ],
        default => [],
    };
@endphp

<aside class="sigap-sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-fire"></i>
        </div>
        <div>
            <div class="fw-bold fs-4">SIGAP</div>
            <small>Sistem Informasi Karhutla</small>
        </div>
    </div>

    <div class="sidebar-role">
        <small class="text-uppercase">Login sebagai</small>
        <div class="fw-semibold mt-1">
            @if($role === 'pusdalops')
                BPBD Pusdalops
            @elseif($role === 'damkar')
                Petugas Damkar
            @elseif($role === 'rr')
                BPBD Divisi RR
            @endif
        </div>
    </div>

    <nav class="sidebar-menu">
        @foreach($menus as $menu)
            @if(isset($menu['route']) && Route::has($menu['route']))
                <a href="{{ route($menu['route']) }}"
                   class="sidebar-link {{ request()->routeIs($menu['route']) ? 'active' : '' }}">
                    <i class="bi {{ $menu['icon'] }}"></i>
                    <span>{{ $menu['label'] }}</span>
                </a>
            @else
                <span class="sidebar-link disabled-menu"
                      title="Fitur sedang dikembangkan">
                    <i class="bi {{ $menu['icon'] }}"></i>
                    <span>{{ $menu['label'] }}</span>
                    <i class="bi bi-lock ms-auto small"></i>
                </span>
            @endif
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <div class="small mb-3">
            <i class="bi bi-person-circle me-2"></i>
            {{ auth()->user()->name }}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                Keluar
            </button>
        </form>
    </div>
</aside>


<style>
    .sigap-sidebar {
        width: 265px;
        min-height: 100vh;
        background: #1F352D;
        color: #F7F5EF;
        display: flex;
        flex-direction: column;
        position: sticky;
        top: 0;
        flex-shrink: 0;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 28px 22px;
        border-bottom: 1px solid rgba(255,255,255,.10);
    }

    .brand-icon {
        width: 46px;
        height: 46px;
        background: #C47B52;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .sidebar-brand small {
        color: #C2CEC5;
        font-size: 11px;
    }

    .sidebar-role {
        padding: 22px;
        border-bottom: 1px solid rgba(255,255,255,.10);
    }

    .sidebar-role small {
        color: #AEBFB3;
        font-size: 10px;
        letter-spacing: 1.2px;
    }

    .sidebar-menu {
        padding: 18px 12px;
        flex: 1;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 12px 14px;
        margin-bottom: 4px;
        color: #C5D0C8;
        text-decoration: none;
        border-radius: 9px;
        font-size: 13px;
        transition: .2s;
    }

    .sidebar-link i {
        font-size: 17px;
    }

    .sidebar-link:hover,
    .sidebar-link.active {
        background: #C47B52;
        color: #FFFFFF;
    }

    .disabled-menu {
        opacity: .42;
        cursor: not-allowed;
    }

    .disabled-menu:hover {
        background: transparent;
        color: #C5D0C8;
    }

    .sidebar-footer {
        padding: 20px;
        border-top: 1px solid rgba(255,255,255,.10);
    }

    .btn-logout {
        width: 100%;
        background: rgba(255,255,255,.04);
        border: 1px solid rgba(255,255,255,.22);
        color: #F7F5EF;
        border-radius: 8px;
        padding: 10px;
        text-align: left;
        cursor: pointer;
        transition: .2s;
    }

    .btn-logout:hover {
        background: #C47B52;
        border-color: #C47B52;
    }

    @media (max-width: 768px) {
        .sigap-sidebar {
            width: 100%;
            min-height: auto;
            position: static;
        }
    }
</style>
