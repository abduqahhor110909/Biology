@extends('layouts.admin')

@section('title', 'Boshqaruv Paneli')

@section('content')

<!-- Stat summary grid -->
<div class="stat-summary-grid">
    <div class="summary-card">
        <div class="summary-icon green">
            <i class="bi bi-journal-text"></i>
        </div>
        <div>
            <div class="summary-value">{{ $stats['articles_count'] }}</div>
            <div class="summary-label">Biologiya Maqolalari</div>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon amber">
            <i class="bi bi-badge-ad"></i>
        </div>
        <div>
            <div class="summary-value">{{ $stats['banners_count'] }}</div>
            <div class="summary-label">Faol Reklamalar</div>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon blue">
            <i class="bi bi-camera-video"></i>
        </div>
        <div>
            <div class="summary-value">{{ $stats['webinars_count'] }}</div>
            <div class="summary-label">Vebinarlar</div>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon purple">
            <i class="bi bi-envelope-paper"></i>
        </div>
        <div>
            <div class="summary-value">{{ $stats['inquiries_count'] }}</div>
            <div class="summary-label">Kelib tushgan arizalar ({{ $stats['new_inquiries'] }} yangi)</div>
        </div>
    </div>
</div>

<!-- Quick Action Shortcuts -->
<div class="admin-card">
    <div class="card-header-flex">
        <h3>Tezkor Amallar</h3>
    </div>
    <div style="display: flex; gap: 14px; flex-wrap: wrap;">
        <a href="{{ route('admin.settings') }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-link-45deg"></i> Telegram & Instagram linklarni yangilash
        </a>
        <a href="{{ route('admin.banners.create') }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-plus-circle"></i> Yangi Reklama / Banner qo'shish
        </a>
        <a href="{{ route('admin.articles.create') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-pencil-square"></i> Yangi Ilmiy Maqola yozish
        </a>
        <a href="{{ route('admin.webinars.create') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-calendar-plus"></i> Yangi Vebinar e'lon qilish
        </a>
        <a href="{{ route('admin.stats') }}" class="btn-admin btn-admin-outline">
            <i class="bi bi-123"></i> Statistika hisoblagichlarini tahrirlash
        </a>
    </div>
</div>

<div class="form-grid-2">
    <!-- Recent Inquiries -->
    <div class="admin-card">
        <div class="card-header-flex">
            <h3>So'nggi Kelib Tushgan Arizalar</h3>
            <a href="{{ route('admin.inquiries') }}" class="btn-admin btn-admin-outline" style="font-size: 0.8rem;">Barchasi</a>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Ism</th>
                        <th>Telefon</th>
                        <th>Yo'nalish</th>
                        <th>Holati</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentInquiries as $inq)
                    <tr>
                        <td style="font-weight: 700;">{{ $inq->name }}</td>
                        <td>{{ $inq->phone }}</td>
                        <td><span style="font-size: 0.82rem; color: #475569;">{{ Str::limit($inq->interest, 20) }}</span></td>
                        <td>
                            <span class="badge-status {{ $inq->status }}">
                                {{ $inq->status == 'new' ? 'Yangi' : ($inq->status == 'contacted' ? 'Bog\'lanildi' : 'Tugallangan') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">Arizalar mavjud emas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Active Banners / Promos -->
    <div class="admin-card">
        <div class="card-header-flex">
            <h3>Faol Reklama Bannerlari</h3>
            <a href="{{ route('admin.banners.index') }}" class="btn-admin btn-admin-outline" style="font-size: 0.8rem;">Boshqarish</a>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Sarlavha</th>
                        <th>Pozitsiyasi</th>
                        <th>Holati</th>
                        <th>Amal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeBanners as $b)
                    <tr>
                        <td style="font-weight: 700;">{{ Str::limit($b->title, 28) }}</td>
                        <td><code>{{ $b->position }}</code></td>
                        <td>
                            <span class="badge-status {{ $b->is_active ? 'active' : 'inactive' }}">
                                {{ $b->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.banners.edit', $b->id) }}" class="btn-admin btn-admin-outline" style="padding: 4px 8px; font-size: 0.78rem;">
                                Tahrirlash
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">Bannerlar yo'q</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
