@extends('layouts.admin')

@section('title', 'Reklama Bannerini Tahrirlash')

@section('content')

<div class="admin-card" style="max-width: 800px;">
    <div class="card-header-flex">
        <h3>Bannerni Tahrirlash: {{ $banner->title }}</h3>
        <a href="{{ route('admin.banners.index') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
    </div>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Banner Sarlavhasi *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" required>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Belgi / Badge</label>
                <input type="text" name="badge" class="form-control" value="{{ old('badge', $banner->badge) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Banner Joylashuvi</label>
                <select name="position" class="form-control">
                    <option value="middle_feed" {{ $banner->position == 'middle_feed' ? 'selected' : '' }}>O'rta qism (Maqolalar va darslar orasida)</option>
                    <option value="hero_bottom" {{ $banner->position == 'hero_bottom' ? 'selected' : '' }}>Hero qismidan so'ng</option>
                    <option value="sidebar" {{ $banner->position == 'sidebar' ? 'selected' : '' }}>Yon panel</option>
                    <option value="footer" {{ $banner->position == 'footer' ? 'selected' : '' }}>Footer ustida</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Tavsif (Matn)</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $banner->description) }}</textarea>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Tugma Matni *</label>
                <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $banner->button_text) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Tugma Havolasi (URL) *</label>
                <input type="text" name="button_url" class="form-control" value="{{ old('button_url', $banner->button_url) }}" required>
            </div>
        </div>

        <div class="form-grid-2">
            <div>
                <label class="form-label">Yangi Rasm Yuklash</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
                <input type="text" name="image_url" class="form-control" style="margin-top: 8px;" value="{{ $banner->image }}" placeholder="/images/promo-banner.jpg">
            </div>

            <div>
                <label class="form-label">Joriy Rasm</label>
                <img src="{{ asset($banner->image ?? 'images/promo-banner.jpg') }}" alt="Banner" style="max-height: 120px; border-radius: 10px; border: 1px solid #cbd5e1; object-fit: cover;">
            </div>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }}> Bannerni saytda faol ko'rsatish
            </label>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px;">
            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 24px;">
                <i class="bi bi-check-lg"></i> O'zgarishlarni Saqlash
            </button>
            <a href="{{ route('admin.banners.index') }}" class="btn-admin btn-admin-outline" style="padding: 12px 20px;">Bekor qilish</a>
        </div>
    </form>
</div>

@endsection
