@extends('layouts.admin')

@section('title', 'Sayt Sozlamalari, Linklar va Dizayn')

@section('content')

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- 1. Ijtimoiy Tarmoq Linklari (Telegram & Instagram) -->
    <div class="admin-card">
        <div class="card-header-flex">
            <h3><i class="bi bi-share-fill text-emerald-600"></i> Ijtimoiy Tarmoqlar va Aloqa Linklari</h3>
        </div>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">
            Saytning tepa qismida, floating vidjetda va footerda ko'rinadigan Telegram, Instagram va boshqa sahifalar havolalari.
        </p>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label"><i class="bi bi-telegram text-sky-500"></i> Telegram Havolasi (URL)</label>
                <input type="url" name="telegram_url" class="form-control" value="{{ $settings['telegram_url'] ?? 'https://t.me/biology_edu_uz' }}" placeholder="https://t.me/kanalingiz">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="bi bi-telegram text-sky-500"></i> Telegram Kanal Nomi (Masalan: @biology_uz)</label>
                <input type="text" name="telegram_channel" class="form-control" value="{{ $settings['telegram_channel'] ?? '@biology_edu_uz' }}">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="bi bi-instagram text-pink-500"></i> Instagram Havolasi (URL)</label>
                <input type="url" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] ?? 'https://instagram.com/biology_edu_uz' }}" placeholder="https://instagram.com/sahifangiz">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="bi bi-youtube text-red-500"></i> YouTube Havolasi (URL)</label>
                <input type="url" name="youtube_url" class="form-control" value="{{ $settings['youtube_url'] ?? 'https://youtube.com/@biology_edu_uz' }}" placeholder="https://youtube.com/@kanalingiz">
            </div>
        </div>

        <div class="form-grid-2" style="margin-top: 10px;">
            <div class="form-group">
                <label class="form-label"><i class="bi bi-telephone-fill text-emerald-600"></i> Asosiy Telefon Raqam (Header uchun)</label>
                <input type="text" name="phone_primary" class="form-control" value="{{ $settings['phone_primary'] ?? '+998 (71) 200-45-45' }}">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="bi bi-telephone-plus text-emerald-600"></i> Qo'shimcha Telefon Raqam</label>
                <input type="text" name="phone_secondary" class="form-control" value="{{ $settings['phone_secondary'] ?? '+998 (90) 840-05-05' }}">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="bi bi-envelope-fill text-emerald-600"></i> Rasmiy Email</label>
                <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? 'info@biosfera-edu.uz' }}">
            </div>

            <div class="form-group">
                <label class="form-label"><i class="bi bi-clock-fill text-emerald-600"></i> Ish Vaqti</label>
                <input type="text" name="working_hours" class="form-control" value="{{ $settings['working_hours'] ?? 'Dushanba - Shanba: 08:30 - 20:00' }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="bi bi-geo-alt-fill text-emerald-600"></i> Manzil</label>
            <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? 'Toshkent sh., Yunusobod tumani, Amir Temur shoh ko\'chasi, 108' }}">
        </div>
    </div>

    <!-- 2. Hero Seksiyasi va Matnlari (Bosh Sahifa) -->
    <div class="admin-card">
        <div class="card-header-flex">
            <h3><i class="bi bi-layout-text-window-reverse text-emerald-600"></i> Bosh Sahifa (Hero Seksiyasi) Matnlari</h3>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Sayt Nomi (Logotip)</label>
                <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'BioSfera' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Sayt Shiori (Tagline)</label>
                <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? 'Zamonaviy Biologiya va Tibbiyot Ta\'lim Markazi' }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Kichik Belgilash / Badge (Masalan: Bepul Vebinar & Master-klass)</label>
            <input type="text" name="hero_badge" class="form-control" value="{{ $settings['hero_badge'] ?? 'Bepul Vebinar & Master-klass' }}">
        </div>

        <div class="form-group">
            <label class="form-label">Asosiy Katta Yashil Sarlavha (Hero Title)</label>
            <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? 'BIOLOGIYA ILMI VA GENETIKA' }}" style="font-weight: 800; color: #15803d;">
        </div>

        <div class="form-group">
            <label class="form-label">Qisqacha Tavsif (Hero Subtitle)</label>
            <textarea name="hero_subtitle" class="form-control" rows="3">{{ $settings['hero_subtitle'] ?? 'Professional biologlar, bo\'lajak tibbiyot talabalari va biologiya ixlosmandlari uchun interaktiv darslar, amaliy mikroskopiya va ilmiy tadqiqotlar portali.' }}</textarea>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">1-Asosiy Yashil Tugma Matni</label>
                <input type="text" name="hero_btn_primary_text" class="form-control" value="{{ $settings['hero_btn_primary_text'] ?? 'Ro\'yxatdan o\'tish' }}">
            </div>
            <div class="form-group">
                <label class="form-label">1-Tugma Havolasi (Link)</label>
                <input type="text" name="hero_btn_primary_link" class="form-control" value="{{ $settings['hero_btn_primary_link'] ?? '#register' }}">
            </div>

            <div class="form-group">
                <label class="form-label">2-Chegaralangan Tugma Matni</label>
                <input type="text" name="hero_btn_secondary_text" class="form-control" value="{{ $settings['hero_btn_secondary_text'] ?? 'Batafsil ma\'lumot' }}">
            </div>
            <div class="form-group">
                <label class="form-label">2-Tugma Havolasi (Link)</label>
                <input type="text" name="hero_btn_secondary_link" class="form-control" value="{{ $settings['hero_btn_secondary_link'] ?? '#courses' }}">
            </div>
        </div>
    </div>

    <!-- 3. Rasm va Dizayn Sozlamalari (Hero Image & Color) -->
    <div class="admin-card">
        <div class="card-header-flex">
            <h3><i class="bi bi-palette-fill text-emerald-600"></i> Rasm va Dizayn Sozlamalari</h3>
        </div>

        <div class="form-grid-2">
            <div>
                <label class="form-label">Bosh Sahifa Asosiy Rasmi (Hero Image)</label>
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 12px;">Yangi rasm yuklang yoki mavjud manzilni kiriting:</p>
                <input type="file" name="hero_image_file" class="form-control" accept="image/*" style="margin-bottom: 12px;">
                <input type="text" name="hero_image" class="form-control" value="{{ $settings['hero_image'] ?? '/images/hero-banner.jpg' }}" placeholder="/images/hero-banner.jpg">
            </div>

            <div>
                <label class="form-label">Joriy Rasm Ko'rinishi</label>
                <div style="border-radius: 12px; overflow: hidden; border: 1px solid #cbd5e1; max-height: 180px;">
                    <img src="{{ asset($settings['hero_image'] ?? 'images/hero-banner.jpg') }}" alt="Hero banner" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <div class="form-section-title">
            <i class="bi bi-megaphone-fill"></i> Yuqori E'lon Lentasi (Top Announcement Bar)
        </div>
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Lenta Holati</label>
                <select name="announcement_active" class="form-control">
                    <option value="1" {{ ($settings['announcement_active'] ?? '1') == '1' ? 'selected' : '' }}>Faol (Ko'rsatilsin)</option>
                    <option value="0" {{ ($settings['announcement_active'] ?? '1') == '0' ? 'selected' : '' }}>O'chirilgan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">E'lon Matni</label>
                <input type="text" name="announcement_text" class="form-control" value="{{ $settings['announcement_text'] ?? '' }}">
            </div>
        </div>
    </div>

    <!-- Saqlash tugmasi -->
    <div style="position: sticky; bottom: 20px; background: #ffffff; padding: 18px 24px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 1px solid #cbd5e1; display: flex; align-items: center; justify-content: space-between; z-index: 100;">
        <span style="font-size: 0.95rem; color: #475569;">Barcha o'zgarishlarni saytda darhol qo'llash uchun saqlang.</span>
        <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 30px; font-size: 1rem;">
            <i class="bi bi-check-lg"></i> O'zgarishlarni Saqlash
        </button>
    </div>
</form>

@endsection
