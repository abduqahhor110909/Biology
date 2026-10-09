@extends('layouts.admin')

@section('title', 'Vebinarni Tahrirlash')

@section('content')

<div class="admin-card" style="max-width: 800px;">
    <div class="card-header-flex">
        <h3>Vebinarni Tahrirlash: {{ $webinar->title }}</h3>
        <a href="{{ route('admin.webinars.index') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
    </div>

    <form action="{{ route('admin.webinars.update', $webinar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Vebinar Sarlavhasi *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $webinar->title) }}" required>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Spiker / O'qituvchi Ismi *</label>
                <input type="text" name="instructor_name" class="form-control" value="{{ old('instructor_name', $webinar->instructor_name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Spiker Unvoni / Lavozimi</label>
                <input type="text" name="instructor_title" class="form-control" value="{{ old('instructor_title', $webinar->instructor_title) }}">
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Sana va Vaqt Matni *</label>
                <input type="text" name="date_time_text" class="form-control" value="{{ old('date_time_text', $webinar->date_time_text) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Davomiyligi</label>
                <input type="text" name="duration" class="form-control" value="{{ old('duration', $webinar->duration) }}">
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Belgi / Badge</label>
                <input type="text" name="badge" class="form-control" value="{{ old('badge', $webinar->badge) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Qatnashish Havolasi (Link)</label>
                <input type="text" name="join_link" class="form-control" value="{{ old('join_link', $webinar->join_link) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Qisqacha Tavsif</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $webinar->description) }}</textarea>
        </div>

        <div class="form-grid-2">
            <div>
                <label class="form-label">Yangi Rasm Yuklash</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
                <input type="text" name="image_url" class="form-control" style="margin-top: 6px;" value="{{ $webinar->image }}">
            </div>
            <div>
                <label class="form-label">Joriy Rasm</label>
                <img src="{{ asset($webinar->image ?? 'images/promo-banner.jpg') }}" alt="Vebinar" style="max-height: 120px; border-radius: 10px; border: 1px solid #cbd5e1; object-fit: cover;">
            </div>
        </div>

        <div class="form-grid-2" style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_free" value="1" {{ $webinar->is_free ? 'checked' : '' }}> Bepul vebinar
            </label>

            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_active" value="1" {{ $webinar->is_active ? 'checked' : '' }}> Saytda ko'rsatilsin
            </label>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px;">
            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 24px;">
                <i class="bi bi-check-lg"></i> O'zgarishlarni Saqlash
            </button>
            <a href="{{ route('admin.webinars.index') }}" class="btn-admin btn-admin-outline" style="padding: 12px 20px;">Bekor qilish</a>
        </div>
    </form>
</div>

@endsection
