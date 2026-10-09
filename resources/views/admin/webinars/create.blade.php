@extends('layouts.admin')

@section('title', 'Yangi Vebinar Qo\'shish')

@section('content')

<div class="admin-card" style="max-width: 800px;">
    <div class="card-header-flex">
        <h3>Yangi Vebinar E'lon Qilish</h3>
        <a href="{{ route('admin.webinars.index') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
    </div>

    <form action="{{ route('admin.webinars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">Vebinar Sarlavhasi *</label>
            <input type="text" name="title" class="form-control" placeholder="Masalan: Genetik muhandislik va biotexnologiya" required>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Spiker / O'qituvchi Ismi *</label>
                <input type="text" name="instructor_name" class="form-control" placeholder="Prof. Alisher Qosimov" required>
            </div>

            <div class="form-group">
                <label class="form-label">Spiker Unvoni / Lavozimi</label>
                <input type="text" name="instructor_title" class="form-control" placeholder="Biologiya fanlari doktori">
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Sana va Vaqt Matni *</label>
                <input type="text" name="date_time_text" class="form-control" value="28-Oktabr, 19:00" required>
            </div>

            <div class="form-group">
                <label class="form-label">Davomiyligi</label>
                <input type="text" name="duration" class="form-control" value="90 daqiqa">
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Belgi / Badge</label>
                <input type="text" name="badge" class="form-control" value="Bepul Vebinar">
            </div>

            <div class="form-group">
                <label class="form-label">Qatnashish Havolasi (Link)</label>
                <input type="text" name="join_link" class="form-control" value="#register" placeholder="#register yoki https://zoom.us/...">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Qisqacha Tavsif</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Vebinar kimlar uchun va qanday mavzular yoritiladi..."></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Vebinar Rasmini Yuklash</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
            <input type="text" name="image_url" class="form-control" style="margin-top: 6px;" placeholder="/images/promo-banner.jpg">
        </div>

        <div class="form-grid-2" style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_free" value="1" checked> Bepul vebinar
            </label>

            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_active" value="1" checked> Saytda ko'rsatilsin
            </label>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px;">
            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 24px;">
                <i class="bi bi-check-lg"></i> Vebinarni Saqlash
            </button>
            <a href="{{ route('admin.webinars.index') }}" class="btn-admin btn-admin-outline" style="padding: 12px 20px;">Bekor qilish</a>
        </div>
    </form>
</div>

@endsection
