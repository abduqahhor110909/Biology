@extends('layouts.admin')

@section('title', 'Maqolani Tahrirlash')

@section('content')

<div class="admin-card" style="max-width: 900px;">
    <div class="card-header-flex">
        <h3>Maqolani Tahrirlash: {{ $article->title }}</h3>
        <a href="{{ route('admin.articles.index') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
    </div>

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Maqola Sarlavhasi *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Biologiya Bo'limi (Kategoriya)</label>
                <select name="category_id" class="form-control">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $article->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Taxminiy O'qish Vaqti</label>
                <input type="text" name="read_time" class="form-control" value="{{ old('read_time', $article->read_time) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Qisqacha Tavsif (Excerpt)</label>
            <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $article->excerpt) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">To'liq Maqola Matni *</label>
            <textarea name="content" class="form-control" rows="10" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <div class="form-grid-2">
            <div>
                <label class="form-label">Yangi Rasm Yuklash</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
                <input type="text" name="image_url" class="form-control" style="margin-top: 6px;" value="{{ $article->image }}">
            </div>
            <div>
                <label class="form-label">Joriy Rasm</label>
                <img src="{{ asset($article->image ?? 'images/hero-banner.jpg') }}" alt="Maqola rasmi" style="max-height: 120px; border-radius: 10px; border: 1px solid #cbd5e1; object-fit: cover;">
            </div>
        </div>

        <div class="form-grid-2" style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_featured" value="1" {{ $article->is_featured ? 'checked' : '' }}> Asosiy sahifada ajratib ko'rsatish
            </label>

            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" name="is_published" value="1" {{ $article->is_published ? 'checked' : '' }}> Nashr etilgan
            </label>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px;">
            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 24px;">
                <i class="bi bi-check-lg"></i> O'zgarishlarni Saqlash
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn-admin btn-admin-outline" style="padding: 12px 20px;">Bekor qilish</a>
        </div>
    </form>
</div>

@endsection
