@extends('layouts.admin')

@section('title', 'Biologiya Maqolalari Boshqaruvi')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Barcha Ilmiy Maqolalar va Mavzular</h3>
            <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0;">
                O'quvchilar va talabalar uchun biologik maqolalar, ilmiy kashfiyotlar va qiziqarli faktlarni boshqaring.
            </p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-plus-lg"></i> Yangi Maqola Yozish
        </a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Rasm</th>
                    <th>Sarlavha</th>
                    <th>Bo'lim</th>
                    <th>O'qish vaqti</th>
                    <th>Ko'rishlar</th>
                    <th>Holati</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $art)
                <tr>
                    <td style="width: 80px;">
                        <img src="{{ asset($art->image ?? 'images/hero-banner.jpg') }}" alt="{{ $art->title }}" style="width: 70px; height: 50px; object-fit: cover; border-radius: 8px;">
                    </td>
                    <td>
                        <strong style="color: #0f172a; font-size: 0.95rem;">{{ $art->title }}</strong>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">{{ Str::limit($art->excerpt, 60) }}</div>
                    </td>
                    <td>
                        <span class="badge-status active" style="font-size: 0.78rem;">
                            {{ $art->category->name ?? 'Umumiy' }}
                        </span>
                    </td>
                    <td>{{ $art->read_time }}</td>
                    <td><i class="bi bi-eye"></i> {{ number_format($art->views_count) }}</td>
                    <td>
                        <span class="badge-status {{ $art->is_published ? 'active' : 'inactive' }}">
                            {{ $art->is_published ? 'Nashr etilgan' : 'Qoralama' }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('article.show', $art->slug) }}" target="_blank" class="btn-admin btn-admin-outline" style="padding: 6px 10px;" title="Saytda ko'rish">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <a href="{{ route('admin.articles.edit', $art->id) }}" class="btn-admin btn-admin-outline" style="padding: 6px 10px;" title="Tahrirlash">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Maqolani o\'chirishga ishonchingiz komilmi?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin btn-admin-danger" style="padding: 6px 10px;" title="O'chirish">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">Hozircha maqolalar kiritilmagan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $articles->links() }}
    </div>
</div>

@endsection
