<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings['site_name'] ?? 'BioSfera' }} - {{ $settings['site_tagline'] ?? 'Biologiya Ta\'lim Portali' }}</title>
    <meta name="description" content="Zamonaviy biologiya, tibbiyot, genetika va botanika bo'yicha ilmiy-o'quv platformasi. Bepul vebinarlar, darslar va maqolalar.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Main Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    
    @yield('styles')
</head>
<body>

    <!-- 1. Top Announcement Bar -->
    @if(($settings['announcement_active'] ?? '1') == '1' && !empty($settings['announcement_text']))
    <div class="announcement-bar">
        <span>{{ $settings['announcement_text'] }}</span>
        <a href="#register">Batafsil <i class="bi bi-arrow-right"></i></a>
    </div>
    @endif

    <!-- 2. Header (Matching Screenshot Layout) -->
    <header class="site-header">
        <div class="container">
            <!-- Top Utility Row -->
            <div class="header-top">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo-area">
                    <div class="logo-badge">
                        <i class="bi bi-flower1"></i>
                    </div>
                    <div class="logo-text">
                        <h1>{{ $settings['site_name'] ?? 'BioSfera' }}</h1>
                        <span>{{ $settings['site_tagline'] ?? 'Biologiya ilmiy-o\'quv platformasi' }}</span>
                    </div>
                </a>

                <!-- Contacts & Socials (As requested: Instagram & TG links) -->
                <div class="header-contacts">
                    <!-- Phone -->
                    @if(!empty($settings['phone_primary']))
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['phone_primary']) }}" class="phone-item">
                        <div class="phone-icon-wrap">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <span>{{ $settings['phone_primary'] }}</span>
                    </a>
                    @endif

                    <!-- Social Icons -->
                    <div class="social-links">
                        @if(!empty($settings['telegram_url']))
                        <a href="{{ $settings['telegram_url'] }}" target="_blank" rel="noopener" class="social-btn tg" title="Telegram">
                            <i class="bi bi-telegram"></i>
                        </a>
                        @endif

                        @if(!empty($settings['instagram_url']))
                        <a href="{{ $settings['instagram_url'] }}" target="_blank" rel="noopener" class="social-btn ig" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        @endif

                        @if(!empty($settings['youtube_url']))
                        <a href="{{ $settings['youtube_url'] }}" target="_blank" rel="noopener" class="social-btn yt" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                        @endif
                    </div>

                    <!-- Language Badge -->
                    <div class="lang-selector">
                        <span>🇺🇿 O'zbekcha</span>
                    </div>

                    <!-- Mobile Hamburger -->
                    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menyuni ochish">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>

            <!-- Bottom Navigation Bar -->
            <div class="header-nav" id="headerNav">
                <ul class="nav-menu">
                    <li><a href="{{ route('home') }}#hero" class="nav-link active">Bosh sahifa</a></li>
                    <li><a href="{{ route('home') }}#branches" class="nav-link">Yo'nalishlar</a></li>
                    <li><a href="{{ route('home') }}#articles" class="nav-link">Maqolalar & Ilm-fan</a></li>
                    <li><a href="{{ route('home') }}#webinars" class="nav-link">Vebinarlar</a></li>
                    <li><a href="{{ route('home') }}#quiz" class="nav-link">Viktorina Test</a></li>
                    <li><a href="{{ route('home') }}#register" class="nav-link">Bog'lanish</a></li>
                </ul>

                <div class="nav-actions">
                    <a href="{{ route('admin.login') }}" class="admin-badge-btn" title="Admin Boshqaruv Paneli">
                        <i class="bi bi-shield-lock-fill"></i> Admin Panel
                    </a>
                    <a href="#register" class="btn-primary-sm">
                        Qabulga yozilish
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Yield -->
    <main>
        @yield('content')
    </main>

    <!-- 3. Floating Quick Social Links Dock -->
    <div class="floating-social-dock">
        @if(!empty($settings['telegram_url']))
        <a href="{{ $settings['telegram_url'] }}" target="_blank" rel="noopener" class="dock-btn tg" title="Telegram orqali bog'lanish">
            <i class="bi bi-telegram"></i>
        </a>
        @endif

        @if(!empty($settings['instagram_url']))
        <a href="{{ $settings['instagram_url'] }}" target="_blank" rel="noopener" class="dock-btn ig" title="Instagram sahifamiz">
            <i class="bi bi-instagram"></i>
        </a>
        @endif
    </div>

    <!-- 4. Site Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="logo-area" style="margin-bottom: 16px;">
                        <div class="logo-badge">
                            <i class="bi bi-flower1"></i>
                        </div>
                        <div class="logo-text">
                            <h2 style="color: #fff; font-size: 1.3rem;">{{ $settings['site_name'] ?? 'BioSfera' }}</h2>
                            <span style="color: #94a3b8;">{{ $settings['site_tagline'] ?? 'Biologiya ta\'lim platformasi' }}</span>
                        </div>
                    </div>
                    <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px;">
                        Zamonaviy biologiya, biotexnologiya va tibbiyot sohasida ilg'or bilimlar, interaktiv darslar va xalqaro olimpiadalarga tayyorgarlik markazi.
                    </p>
                    <div class="social-links">
                        @if(!empty($settings['telegram_url']))
                        <a href="{{ $settings['telegram_url'] }}" target="_blank" class="social-btn tg"><i class="bi bi-telegram"></i></a>
                        @endif
                        @if(!empty($settings['instagram_url']))
                        <a href="{{ $settings['instagram_url'] }}" target="_blank" class="social-btn ig"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if(!empty($settings['youtube_url']))
                        <a href="{{ $settings['youtube_url'] }}" target="_blank" class="social-btn yt"><i class="bi bi-youtube"></i></a>
                        @endif
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Asosiy Bo'limlar</h4>
                    <ul class="footer-links">
                        <li><a href="#branches">Botanika & O'simliklar</a></li>
                        <li><a href="#branches">Zoologiya & Jonivorlar</a></li>
                        <li><a href="#branches">Sitologiya & Hujayra</a></li>
                        <li><a href="#branches">Molekulyar Genetika</a></li>
                        <li><a href="#branches">Odam Anatomiyasi</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Foydali Havolalar</h4>
                    <ul class="footer-links">
                        <li><a href="#webinars">Ochiq Vebinarlar</a></li>
                        <li><a href="#articles">Ilmiy Maqolalar</a></li>
                        <li><a href="#quiz">Interaktiv Viktorina</a></li>
                        <li><a href="#register">Bepul Maslahat</a></li>
                        <li><a href="{{ route('admin.login') }}">Boshqaruv Paneli</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Bog'lanish & Manzil</h4>
                    <ul class="footer-links" style="font-size: 0.9rem;">
                        <li><i class="bi bi-geo-alt-fill text-emerald-500"></i> {{ $settings['address'] ?? 'Toshkent sh., Yunusobod tumani' }}</li>
                        <li><i class="bi bi-telephone-fill text-emerald-500"></i> {{ $settings['phone_primary'] ?? '+998 (71) 200-45-45' }}</li>
                        <li><i class="bi bi-envelope-fill text-emerald-500"></i> {{ $settings['email'] ?? 'info@biosfera-edu.uz' }}</li>
                        <li><i class="bi bi-clock-fill text-emerald-500"></i> {{ $settings['working_hours'] ?? 'Dush-Shanba 08:30-20:00' }}</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'BioSfera' }}. Barcha huquqlar himoyalangan.</p>
                <p>Biologiya va ilmiy innovatsiyalar ta'lim portali.</p>
            </div>
        </div>
    </footer>

    <!-- Client Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
</body>
</html>
