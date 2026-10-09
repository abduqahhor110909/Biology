@extends('layouts.app')

@section('content')

<!-- ==========================================================================
     1. HERO SECTION (Designed directly following user screenshot layout)
     ========================================================================== -->
<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-grid">
            <!-- Left Column: Texts and CTA -->
            <div class="hero-content fade-up">
                <!-- Badge -->
                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    <span>{{ $settings['hero_badge'] ?? 'Bepul Vebinar & Master-klass' }}</span>
                </div>

                <!-- Main Green Headline (from reference image) -->
                <h1 class="hero-title">
                    {{ $settings['hero_title'] ?? 'BIOLOGIYA ILMI VA GENETIKA' }}
                </h1>

                <!-- Subtitle -->
                <p class="hero-subtitle">
                    {{ $settings['hero_subtitle'] ?? 'Professional biologlar, bo\'lajak tibbiyot talabalari va biologiya ixlosmandlari uchun interaktiv darslar, amaliy mikroskopiya va ilmiy tadqiqotlar portali.' }}
                </p>

                <!-- Action Buttons (Solid Green & Outlined buttons from reference) -->
                <div class="hero-cta-group">
                    <a href="{{ $settings['hero_btn_primary_link'] ?? '#register' }}" class="btn-hero-primary">
                        <span>{{ $settings['hero_btn_primary_text'] ?? 'Ro\'yxatdan o\'tish' }}</span>
                        <i class="bi bi-arrow-right-short" style="font-size: 1.4rem;"></i>
                    </a>
                    
                    <a href="{{ $settings['hero_btn_secondary_link'] ?? '#branches' }}" class="btn-hero-secondary">
                        <span>{{ $settings['hero_btn_secondary_text'] ?? 'Batafsil ma\'lumot' }}</span>
                        <i class="bi bi-compass"></i>
                    </a>
                </div>

                <!-- Trust Perks -->
                <div class="hero-features">
                    <div class="hero-feat-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>100% Amaliy darslar</span>
                    </div>
                    <div class="hero-feat-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Xalqaro sertifikat</span>
                    </div>
                    <div class="hero-feat-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Olimpiada mentorlari</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Visual Imagery with Floating Badges -->
            <div class="hero-visual fade-in">
                <div class="hero-image-wrap">
                    <img src="{{ asset($settings['hero_image'] ?? 'images/hero-banner.jpg') }}" alt="Biologiya darslari va laboratoriya" class="hero-img">

                    <!-- Floating Card 1: Rating -->
                    <div class="floating-glass-card card-top">
                        <div class="floating-icon">
                            <i class="bi bi-star-fill text-yellow-500"></i>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 1rem; color: #065f46;">4.9 / 5.0</div>
                            <div style="font-size: 0.75rem; color: #64748b;">12,000+ O'quvchilar bahosi</div>
                        </div>
                    </div>

                    <!-- Floating Card 2: Interactive Topics -->
                    <div class="floating-glass-card card-bottom">
                        <div class="floating-icon">
                            <i class="bi bi-virus"></i>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 0.95rem; color: #0f172a;">DNK & Sitologiya</div>
                            <div style="font-size: 0.75rem; color: #059669; font-weight: 600;">Jonli laboratoriya tahlillari</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     2. STATS BANNER STRIP (Directly from the screenshot 4000+, 3500+, 1500+, 5500+)
     ========================================================================== -->
<div class="stats-banner-wrap">
    <div class="container">
        <div class="stats-container">
            @foreach($stats as $st)
            <div class="stat-box fade-up">
                <div class="stat-number">
                    <span class="counter-val" data-target="{{ preg_replace('/[^0-9]/', '', $st->number) }}">{{ $st->number }}</span><span>{{ $st->suffix ?? '+' }}</span>
                </div>
                <div class="stat-label">{{ $st->label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ==========================================================================
     3. BIOLOGY BRANCHES & CATEGORIES
     ========================================================================== -->
<section class="section section-alt" id="branches">
    <div class="container">
        <div class="section-head fade-up">
            <span class="section-badge">Ilmiy Yo'nalishlar</span>
            <h2 class="section-title">Biologiyaning Asosiy Bo'limlari</h2>
            <p class="section-desc">Hujayra mikro-dunyosidan to biosfera miqyosigacha bo'lgan barcha hayot shakllarini tizimli va chuqur o'rganing.</p>
        </div>

        <div class="categories-grid">
            @foreach($categories as $cat)
            <div class="cat-card fade-up">
                <div class="cat-icon-wrap">
                    @if($cat->slug == 'botanika')
                        <i class="bi bi-flower1"></i>
                    @elseif($cat->slug == 'zoologiya')
                        <i class="bi bi-bug"></i>
                    @elseif($cat->slug == 'sitologiya')
                        <i class="bi bi-pie-chart-fill"></i>
                    @elseif($cat->slug == 'genetika')
                        <i class="bi bi-bezier2"></i>
                    @elseif($cat->slug == 'anatomiya')
                        <i class="bi bi-heart-pulse-fill"></i>
                    @else
                        <i class="bi bi-capsule"></i>
                    @endif
                </div>
                <h3 class="cat-title">{{ $cat->name }}</h3>
                <p class="cat-desc">{{ $cat->description }}</p>
                <div class="cat-footer">
                    <span class="cat-badge">{{ $cat->articles_count ?? 0 }} ta ilmiy mavzu</span>
                    <a href="#articles" class="cat-link">
                        O'rganish <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==========================================================================
     4. PROMOTIONAL ADVERTISEMENT BANNER (Admin-Managed Ads)
     ========================================================================== -->
@if($middleBanner)
<section class="promo-banner-section">
    <div class="container">
        <div class="promo-banner-card fade-up">
            <div>
                @if($middleBanner->badge)
                <span class="promo-badge">{{ $middleBanner->badge }}</span>
                @endif
                <h2 class="promo-title">{{ $middleBanner->title }}</h2>
                <p class="promo-desc">{{ $middleBanner->description }}</p>
                <a href="{{ $middleBanner->button_url }}" class="promo-btn">
                    <span>{{ $middleBanner->button_text }}</span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>
            </div>
            <div class="promo-img-wrap">
                <img src="{{ asset($middleBanner->image ?? 'images/promo-banner.jpg') }}" alt="{{ $middleBanner->title }}">
            </div>
        </div>
    </div>
</section>
@endif

<!-- ==========================================================================
     5. UPCOMING WEBINARS & MASTERCLASSES
     ========================================================================== -->
<section class="section" id="webinars">
    <div class="container">
        <div class="section-head fade-up">
            <span class="section-badge">Jonli Efirlar & Darslar</span>
            <h2 class="section-title">Bo'lajak Vebinarlar va Ochiq Darslar</h2>
            <p class="section-desc">Yetakchi biologlar, genetiklar va tibbiyot mutaxassislari bilan bevosita muloqot qiling va amaliy bilim oling.</p>
        </div>

        <div class="webinars-grid">
            @foreach($webinars as $web)
            <div class="webinar-card fade-up">
                <div class="webinar-header">
                    <img src="{{ asset($web->image ?? 'images/promo-banner.jpg') }}" alt="{{ $web->title }}" class="webinar-img">
                    <span class="webinar-badge">{{ $web->badge ?? 'Vebinar' }}</span>
                </div>
                <div class="webinar-body">
                    <div class="webinar-schedule">
                        <span><i class="bi bi-calendar-event"></i> {{ $web->date_time_text }}</span>
                        <span><i class="bi bi-clock"></i> {{ $web->duration }}</span>
                    </div>
                    <h3 class="webinar-title">{{ $web->title }}</h3>
                    <p style="color: #64748b; font-size: 0.92rem; margin-bottom: 16px; line-height: 1.5;">
                        {{ $web->description }}
                    </p>
                    <div class="webinar-instructor">
                        <div class="instructor-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="instructor-info">
                            <h5>{{ $web->instructor_name }}</h5>
                            <p>{{ $web->instructor_title }}</p>
                        </div>
                    </div>
                    <div class="webinar-footer">
                        <span class="webinar-price">{{ $web->is_free ? 'BEPUL' : ($web->price_text ?? 'Pullik') }}</span>
                        <a href="{{ $web->join_link ?? '#register' }}" class="btn-primary-sm">
                            Qatnashish <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==========================================================================
     6. FEATURED BIOLOGY ARTICLES & SCIENTIFIC KNOWLEDGE
     ========================================================================== -->
<section class="section section-alt" id="articles">
    <div class="container">
        <div class="section-head fade-up">
            <span class="section-badge">Ilm-fan Yangiliklari</span>
            <h2 class="section-title">Tavsiya Etilgan Ilmiy Maqolalar</h2>
            <p class="section-desc">Zamonaviy biologik kashfiyotlar, hujayra fiziologiyasi va gen muhandisligiga oid tahliliy materiallar.</p>
        </div>

        <div class="articles-grid">
            @foreach($articles as $art)
            <div class="article-card fade-up">
                <div class="article-img-wrap">
                    <img src="{{ asset($art->image ?? 'images/hero-banner.jpg') }}" alt="{{ $art->title }}" class="article-img">
                    <span class="article-category-badge">{{ $art->category->name ?? 'Biologiya' }}</span>
                </div>
                <div class="article-body">
                    <div class="article-meta">
                        <span><i class="bi bi-clock"></i> {{ $art->read_time }}</span>
                        <span><i class="bi bi-eye"></i> {{ number_format($art->views_count) }} ko'rildi</span>
                    </div>
                    <h3 class="article-title">
                        <a href="{{ route('article.show', $art->slug) }}">{{ $art->title }}</a>
                    </h3>
                    <p class="article-excerpt">{{ $art->excerpt }}</p>
                    <a href="{{ route('article.show', $art->slug) }}" class="article-read-link">
                        To'liq o'qish <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==========================================================================
     7. INTERACTIVE BIOLOGY QUIZ WIDGET
     ========================================================================== -->
<section class="section" id="quiz">
    <div class="container">
        <div class="section-head fade-up">
            <span class="section-badge">Bilimingizni Sinang</span>
            <h2 class="section-title">Interaktiv Biologiya Viktorinasi</h2>
            <p class="section-desc">O'z biologik bilimlaringizni sinab ko'ring va to'g'ri javoblarning ilmiy izohini darhol bilib oling!</p>
        </div>

        <div class="quiz-widget-card fade-up">
            @foreach($quizzes as $index => $q)
            <div class="quiz-question-box" style="{{ $index > 0 ? 'margin-top: 36px; padding-top: 30px; border-top: 1px dashed #cbd5e1;' : '' }}">
                <div class="quiz-q-title">
                    <span style="color: #059669; font-weight: 800;">{{ $index + 1 }}-savol:</span> {{ $q->question }}
                </div>
                <div class="quiz-options-list">
                    <button type="button" class="quiz-opt-btn" data-option="a" onclick="checkQuizAnswer(this, '{{ $q->correct_option }}', '{{ addslashes($q->explanation) }}', 'feedback-{{ $q->id }}')">
                        <strong>A)</strong> {{ $q->option_a }}
                    </button>
                    <button type="button" class="quiz-opt-btn" data-option="b" onclick="checkQuizAnswer(this, '{{ $q->correct_option }}', '{{ addslashes($q->explanation) }}', 'feedback-{{ $q->id }}')">
                        <strong>B)</strong> {{ $q->option_b }}
                    </button>
                    <button type="button" class="quiz-opt-btn" data-option="c" onclick="checkQuizAnswer(this, '{{ $q->correct_option }}', '{{ addslashes($q->explanation) }}', 'feedback-{{ $q->id }}')">
                        <strong>C)</strong> {{ $q->option_c }}
                    </button>
                    <button type="button" class="quiz-opt-btn" data-option="d" onclick="checkQuizAnswer(this, '{{ $q->correct_option }}', '{{ addslashes($q->explanation) }}', 'feedback-{{ $q->id }}')">
                        <strong>D)</strong> {{ $q->option_d }}
                    </button>
                </div>
                <div class="quiz-feedback" id="feedback-{{ $q->id }}"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==========================================================================
     8. CONSULTATION & REGISTRATION FORM (Leads Saved To Database)
     ========================================================================== -->
<section class="section lead-section" id="register">
    <div class="container">
        <div class="lead-grid">
            <div class="fade-up">
                <span class="section-badge">Qabul & Maslahat</span>
                <h2 class="section-title">Bepul Vebinarga Yoziling Yoki Savol Qoldiring</h2>
                <p class="section-desc">
                    O'quv kursi dasturlari, olimpiada tayyorgarligi va vebinarlar bo'yicha bepul professional konsultatsiya oling. Mutaxassislarimiz barcha savollaringizga batafsil javob berishadi.
                </p>

                <div class="lead-info-list">
                    <div class="lead-info-item">
                        <div class="lead-info-icon"><i class="bi bi-telephone-inbound-fill"></i></div>
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">Telefon orqali tezkor aloqa</div>
                            <div style="color: #64748b; font-size: 0.95rem;">{{ $settings['phone_primary'] ?? '+998 (71) 200-45-45' }}</div>
                        </div>
                    </div>

                    <div class="lead-info-item">
                        <div class="lead-info-icon"><i class="bi bi-telegram"></i></div>
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">Telegram Rasmiy Kanali</div>
                            <div style="color: #64748b; font-size: 0.95rem;">
                                <a href="{{ $settings['telegram_url'] ?? '#' }}" target="_blank" style="color: #059669; font-weight: 600;">
                                    {{ $settings['telegram_channel'] ?? '@biology_edu_uz' }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="lead-info-item">
                        <div class="lead-info-icon"><i class="bi bi-instagram"></i></div>
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">Instagram Sahifamiz</div>
                            <div style="color: #64748b; font-size: 0.95rem;">
                                <a href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank" style="color: #059669; font-weight: 600;">
                                    Biologiya yangiliklari va master-klasslar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="lead-form-card fade-up">
                <h3 style="font-size: 1.45rem; font-weight: 800; color: #065f46; margin-bottom: 20px;">
                    Ariza qoldirish
                </h3>

                <form id="inquiryForm" action="{{ route('inquiry.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Ism va Familiyangiz *</label>
                        <input type="text" name="name" class="form-control" placeholder="Masalan: Sardor Aliyev" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Telefon raqamingiz *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+998 90 123 45 67" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Qiziqtirgan yo'nalish</label>
                        <select name="interest" class="form-control">
                            <option value="Bepul Vebinarga yozilish">Bepul Vebinarga yozilish</option>
                            <option value="Molekulyar Genetika kursi">Molekulyar Genetika kursi</option>
                            <option value="Tibbiyotga tayyorgarlik (Anatomiya)">Tibbiyotga tayyorgarlik (Anatomiya)</option>
                            <option value="Biologiya Olimpiadasi kursi">Biologiya Olimpiadasi kursi</option>
                            <option value="Botanika va Zoologiya">Botanika va Zoologiya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Qo'shimcha izoh yoki savolingiz</label>
                        <textarea name="message" class="form-control" rows="3" placeholder="Sizni qiziqtirgan savol..."></textarea>
                    </div>

                    <button type="submit" class="form-btn-submit">
                        Arizani yuborish <i class="bi bi-send-fill" style="margin-left: 6px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
