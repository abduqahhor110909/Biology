@extends('layouts.admin')

@section('title', 'Yangi Maqola Yozish')

@section('content')

<div class="admin-card" style="max-width: 900px;">
    <div class="card-header-flex">
        <h3>Yangi Ilmiy Maqola Yaratish</h3>
        <a href="{{ route('admin.articles.index') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
    </div>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">Maqola Sarlavhasi *</label>
            <input type="text" name="title" class="form-control" placeholder="Masalan: Mitoxondriya: Hujayraning energetik stansiyasi" required>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Biologiya Bo'limi (Kategoriya)</label>
                <select name="category_id" class="form-control">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Taxminiy O'qish Vaqti</label>
                <input type="text" name="read_time" class="form-control" value="5 daqiqa">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Qisqacha Tavsif (Excerpt / Anotatsiya)</label>
            <textarea name="excerpt" class="form-control" rows="2" placeholder="Maqolaning asosiy mazmuni haqida 1-2 jumlali qisqa tavsif..."></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">To'liq Maqola Matni (HTML qo'llab-quvvatlaydi) *</label>
            <textarea name="content" class="form-control" rows="10" placeholder="Maqola mazmuni, paragraflar, ilmiy dalillar..." required></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Maqola Rasmini Yuklash</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
            <input type="text" name="image_url" class="form-control" style="margin-top: 6px;" placeholder="Yoki rasm URL manzilini yozing (/images/hero-banner.jpg)">
        </div>

        <div class="form-grid-2" style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_featured" value="1"> Asosiy sahifada ajratib ko'rsatish (Featured)
            </label>

            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_published" value="1" checked> Darhol nashr qilish
            </label>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px;">
            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 24px;">
                <i class="bi bi-check-lg"></i> Maqolani Saqlash
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn-admin btn-admin-outline" style="padding: 12px 20px;">Bekor qilish</a>
        </div>
    </form>
</div>

@endsection
