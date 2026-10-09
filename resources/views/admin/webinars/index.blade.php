@extends('layouts.admin')

@section('title', 'Vebinarlar va Darslar Boshqaruvi')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Barcha Ochiq Vebinarlar va Master-klasslar</h3>
            <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0;">
                O'quvchilar uchun onlayn darslar, mutaxassislar ma'ruzalari va sanalarini boshqaring.
            </p>
        </div>
        <a href="{{ route('admin.webinars.create') }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-plus-lg"></i> Yangi Vebinar Qo'shish
        </a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Rasm</th>
                    <th>Vebinar Nomi</th>
                    <th>Spiker / O'qituvchi</th>
                    <th>Sana & Vaqt</th>
                    <th>Format</th>
                    <th>Holati</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($webinars as $w)
                <tr>
                    <td style="width: 80px;">
                        <img src="{{ asset($w->image ?? 'images/promo-banner.jpg') }}" alt="{{ $w->title }}" style="width: 70px; height: 50px; object-fit: cover; border-radius: 8px;">
                    </td>
                    <td>
                        <strong style="color: #0f172a; font-size: 0.95rem;">{{ $w->title }}</strong>
                        @if($w->badge)
                        <span class="badge-status new" style="font-size: 0.72rem; margin-left: 6px;">{{ $w->badge }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $w->instructor_name }}</div>
                        <div style="font-size: 0.78rem; color: #64748b;">{{ $w->instructor_title }}</div>
                    </td>
                    <td>
                        <div><i class="bi bi-calendar-event"></i> {{ $w->date_time_text }}</div>
                        <small style="color: #64748b;"><i class="bi bi-clock"></i> {{ $w->duration }}</small>
                    </td>
                    <td>
                        <span class="badge-status {{ $w->is_free ? 'active' : 'contacted' }}">
                            {{ $w->is_free ? 'BEPUL' : ($w->price_text ?? 'Pullik') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-status {{ $w->is_active ? 'active' : 'inactive' }}">
                            {{ $w->is_active ? 'Faol' : 'O\'chirilgan' }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.webinars.edit', $w->id) }}" class="btn-admin btn-admin-outline" style="padding: 6px 10px;">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.webinars.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Vebinarni o\'chirmoqchimisiz?');">
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
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">Hozircha vebinarlar kiritilmagan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $webinars->links() }}
    </div>
</div>

@endsection
