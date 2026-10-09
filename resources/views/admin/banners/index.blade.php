@extends('layouts.admin')

@section('title', 'Reklama va Bannerlar Boshqaruvi')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Saytdagi Barcha Reklama va Promo Bannerlar</h3>
            <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0;">
                Bu yerdan maxsus takliflar, vebinarlar va homiylik reklamalarini qo'shishingiz, tahrirlashingiz yoki faolsizlantirishingiz mumkin.
            </p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-plus-lg"></i> Yangi Reklama Qo'shish
        </a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Rasm</th>
                    <th>Sarlavha & Belgilanish</th>
                    <th>Tugma & Link</th>
                    <th>Joylashuvi</th>
                    <th>Holati</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $b)
                <tr>
                    <td style="width: 120px;">
                        <img src="{{ asset($b->image ?? 'images/promo-banner.jpg') }}" alt="{{ $b->title }}" style="width: 100px; height: 60px; object-fit: cover; border-radius: 8px;">
                    </td>
                    <td>
                        @if($b->badge)
                        <span class="badge-status contacted" style="font-size: 0.72rem; margin-bottom: 4px;">{{ $b->badge }}</span><br>
                        @endif
                        <strong style="color: #0f172a; font-size: 0.95rem;">{{ $b->title }}</strong>
                        <div style="color: #64748b; font-size: 0.82rem; margin-top: 4px;">{{ Str::limit($b->description, 80) }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #059669;">{{ $b->button_text }}</div>
                        <a href="{{ $b->button_url }}" target="_blank" style="font-size: 0.78rem; color: #64748b;">
                            {{ Str::limit($b->button_url, 30) }} <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </td>
                    <td>
                        <code>{{ $b->position }}</code>
                    </td>
                    <td>
                        <form action="{{ route('admin.banners.toggle', $b->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="badge-status {{ $b->is_active ? 'active' : 'inactive' }}" style="border: none; cursor: pointer;">
                                {{ $b->is_active ? 'Faol' : 'Nofaol' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.banners.edit', $b->id) }}" class="btn-admin btn-admin-outline" style="padding: 6px 10px;">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham bu reklamani o\'chirmoqchimisiz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin btn-admin-danger" style="padding: 6px 10px;">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">Hozircha reklamalar mavjud emas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $banners->links() }}
    </div>
</div>

@endsection
