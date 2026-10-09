<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boshqaruv Paneli') - BioSfera Admin</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    
    @yield('styles')
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <i class="bi bi-flower1"></i>
                </div>
                <div class="brand-name">
                    BioSfera
                    <span>Boshqaruv Paneli</span>
                </div>
            </div>

            <ul class="sidebar-nav">
                <li class="nav-item-title">Asosiy</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item-title">Tarkib & Dizayn</li>
                <li>
                    <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="bi bi-sliders"></i>
                        <span>Sayt Sozlamalari & Linklar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.banners.index') }}" class="sidebar-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                        <i class="bi bi-badge-ad-fill"></i>
                        <span>Reklama & Bannerlar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.articles.index') }}" class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-richtext"></i>
                        <span>Biologiya Maqolalari</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.webinars.index') }}" class="sidebar-link {{ request()->routeIs('admin.webinars.*') ? 'active' : '' }}">
                        <i class="bi bi-camera-video-fill"></i>
                        <span>Vebinarlar & Darslar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stats') }}" class="sidebar-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}">
                        <i class="bi bi-123"></i>
                        <span>Statistika Hisoblagichlari</span>
                    </a>
                </li>

                <li class="nav-item-title">Murojaatlar</li>
                <li>
                    <a href="{{ route('admin.inquiries') }}" class="sidebar-link {{ request()->routeIs('admin.inquiries') ? 'active' : '' }}">
                        <i class="bi bi-envelope-paper-fill"></i>
                        <span>Kelib tushgan Arizalar</span>
                    </a>
                </li>

                <li class="nav-item-title">Havolalar</li>
                <li>
                    <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                        <i class="bi bi-box-arrow-up-right"></i>
                        <span>Saytni Ko'rish</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="admin-user-pill">
                    <div class="admin-avatar">A</div>
                    <div class="admin-user-info">
                        {{ auth()->user()->name ?? 'Administrator' }}
                        <span>Online</span>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-admin btn-admin-danger" style="padding: 6px 10px;" title="Chiqish">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="admin-main">
            <header class="admin-header">
                <div class="header-page-title">
                    <h2>@yield('title', 'Dashboard')</h2>
                </div>
                <div class="header-quick-links">
                    <a href="{{ route('home') }}" target="_blank" class="btn-admin btn-admin-outline">
                        <i class="bi bi-eye"></i> Saytga o'tish
                    </a>
                    <a href="{{ route('admin.settings') }}" class="btn-admin btn-admin-primary">
                        <i class="bi bi-gear-fill"></i> Sozlamalar
                    </a>
                </div>
            </header>

            <main class="admin-content">
                @if(session('success'))
                <div class="admin-alert-success">
                    <i class="bi bi-check-circle-fill text-emerald-600" style="font-size: 20px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
