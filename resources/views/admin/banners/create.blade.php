@extends('layouts.admin')

@section('title', 'Yangi Reklama / Banner Qo\'shish')

@section('content')

<div class="admin-card" style="max-width: 800px;">
    <div class="card-header-flex">
        <h3>Yangi Reklama Banneri</h3>
        <a href="{{ route('admin.banners.index') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">Banner Sarlavhasi *</label>
            <input type="text" name="title" class="form-control" placeholder="Masalan: Biologiya va Tibbiyot Olimpiadasiga Tayyorgarlik" required>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Belgi / Badge (Masalan: Chegirma -30% yoki Ochiq Dars)</label>
                <input type="text" name="badge" class="form-control" placeholder="Maxsus taklif">
            </div>

            <div class="form-group">
                <label class="form-label">Banner Joylashuvi</label>
                <select name="position" class="form-control">
                    <option value="middle_feed">O'rta qism (Maqolalar va darslar orasida)</option>
                    <option value="hero_bottom">Hero qismidan so'ng</option>
                    <option value="sidebar">Yon panel</option>
                    <option value="footer">Footer ustida</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Tavsif (Matn)</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Reklama yoki taklif haqida batafsil ma'lumot..."></textarea>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Tugma Matni *</label>
                <input type="text" name="button_text" class="form-control" value="Batafsil ma'lumot" required>
            </div>

            <div class="form-group">
                <label class="form-label">Tugma Havolasi (URL) *</label>
                <input type="text" name="button_url" class="form-control" value="#register" placeholder="https://t.me/... yoki #register" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Banner Rasmini Yuklash</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
            <small style="color: #64748b; margin-top: 4px; display: block;">Yoki mavjud rasm manzilini kiriting:</small>
            <input type="text" name="image_url" class="form-control" style="margin-top: 6px;" placeholder="/images/promo-banner.jpg">
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_active" value="1" checked> Bannerni darhol saytda faollashtirish
            </label>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px;">
            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 24px;">
                <i class="bi bi-check-lg"></i> Bannerni Saqlash
            </button>
            <a href="{{ route('admin.banners.index') }}" class="btn-admin btn-admin-outline" style="padding: 12px 20px;">Bekor qilish</a>
        </div>
    </form>
</div>

@endsection
