
@php
    $role = auth()->user()->role ?? null;

    $menus = match ($role) {
        'pusdalops' => [
            ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'pusdalops.dashboard'],            
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
        <div class="mt-1 fw-semibold">
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
        <div class="mb-3 small">
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
        background: #FFFCFA;
        color: #64271D;
        display: flex;
        flex-direction: column;
        position: sticky;
        top: 0;
        flex-shrink: 0;
        border-right: 1px solid #F3E5DF;
        box-shadow: 3px 0 15px rgba(120, 50, 30, .05);
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 28px 22px;
        border-bottom: 1px solid #F5E9E4;
    }

    .brand-icon {
        width: 46px;
        height: 46px;
        background: linear-gradient(135deg, #FF713F, #D92F20);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .sidebar-brand .fw-bold {
        color: #922B1F;
    }

    .sidebar-brand small {
        color: #8F7770;
        font-size: 11px;
    }

    .sidebar-role {
        padding: 22px;
        background: #FFF5F0;
        border-bottom: 1px solid #F5E5DD;
    }

    .sidebar-role small {
        color: #A66B59;
        font-size: 10px;
        letter-spacing: 1.2px;
    }

    .sidebar-role .fw-semibold {
        color: #8D2C20;
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
        margin-bottom: 5px;
        color: #76534A;
        text-decoration: none;
        border-radius: 10px;
        font-size: 13px;
        transition: .2s;
    }

    .sidebar-link i {
        font-size: 17px;
        color: #B9573C;
    }

    .sidebar-link:hover {
        background: #FFF0E9;
        color: #C43C25;
    }

    .sidebar-link.active {
        background: linear-gradient(110deg, #FF713F, #E13B25);
        color: #FFFFFF;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(225, 59, 37, .18);
    }

    .sidebar-link.active i {
        color: #FFFFFF;
    }

    .disabled-menu {
        opacity: .55;
        cursor: not-allowed;
    }

    .disabled-menu:hover {
        background: transparent;
        color: #76534A;
    }

    .sidebar-footer {
        padding: 20px;
        border-top: 1px solid #F5E5DD;
    }

    .sidebar-footer .small {
        color: #76534A;
    }

    .btn-logout {
        width: 100%;
        background: #FFF5F0;
        border: 1px solid #F3CFC0;
        color: #B9432D;
        border-radius: 9px;
        padding: 10px;
        text-align: left;
        cursor: pointer;
        transition: .2s;
    }

    .btn-logout:hover {
        background: linear-gradient(110deg, #FF713F, #E13B25);
        border-color: #E13B25;
        color: #FFFFFF;
    }

    @media (max-width: 768px) {
        .sigap-sidebar {
            width: 100%;
            min-height: auto;
            position: static;
        }
    }
</style>
