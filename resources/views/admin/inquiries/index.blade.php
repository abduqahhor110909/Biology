@extends('layouts.admin')

@section('title', 'Kelib Tushgan Arizalar va Murojaatlar')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Foydalanuvchilar va O'quvchilar Arizalari</h3>
            <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0;">
                Saytdagi konsultatsiya va ro'yxatdan o'tish formasi orqali yuborilgan barcha arizalar.
            </p>
        </div>

        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.inquiries') }}" class="btn-admin {{ empty($status) ? 'btn-admin-primary' : 'btn-admin-outline' }}">
                Barchasi ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.inquiries', ['status' => 'new']) }}" class="btn-admin {{ $status == 'new' ? 'btn-admin-primary' : 'btn-admin-outline' }}">
                Yangi ({{ $counts['new'] }})
            </a>
            <a href="{{ route('admin.inquiries', ['status' => 'contacted']) }}" class="btn-admin {{ $status == 'contacted' ? 'btn-admin-primary' : 'btn-admin-outline' }}">
                Bog'lanildi ({{ $counts['contacted'] }})
            </a>
            <a href="{{ route('admin.inquiries', ['status' => 'completed']) }}" class="btn-admin {{ $status == 'completed' ? 'btn-admin-primary' : 'btn-admin-outline' }}">
                Tugallandi ({{ $counts['completed'] }})
            </a>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Sana</th>
                    <th>F.I.SH</th>
                    <th>Telefon</th>
                    <th>Qiziqtirgan Yo'nalish</th>
                    <th>Izoh / Savol</th>
                    <th>Holati</th>
                    <th>Amal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inq)
                <tr>
                    <td style="white-space: nowrap; font-size: 0.82rem; color: #64748b;">
                        {{ $inq->created_at->format('d.m.Y H:i') }}
                    </td>
                    <td style="font-weight: 700; color: #0f172a;">{{ $inq->name }}</td>
                    <td>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $inq->phone) }}" style="color: #059669; font-weight: 600;">
                            <i class="bi bi-telephone"></i> {{ $inq->phone }}
                        </a>
                    </td>
                    <td>
                        <span class="badge-status active" style="font-size: 0.78rem;">
                            {{ $inq->interest ?? 'Umumiy' }}
                        </span>
                    </td>
                    <td style="max-width: 260px; font-size: 0.85rem; color: #475569;">
                        {{ $inq->message ?: 'Izoh yo\'q' }}
                    </td>
                    <td>
                        <form action="{{ route('admin.inquiries.status', $inq->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-control" style="padding: 4px 8px; font-size: 0.82rem; width: auto; font-weight: 600;">
                                <option value="new" {{ $inq->status == 'new' ? 'selected' : '' }}>🔴 Yangi</option>
                                <option value="contacted" {{ $inq->status == 'contacted' ? 'selected' : '' }}>🟡 Bog'lanildi</option>
                                <option value="completed" {{ $inq->status == 'completed' ? 'selected' : '' }}>🟢 Tugallangan</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.inquiries.destroy', $inq->id) }}" method="POST" onsubmit="return confirm('Arizani o\'chirishga ishonchingiz komilmi?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-admin btn-admin-danger" style="padding: 6px 10px;" title="O'chirish">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">
                        Arizalar topilmadi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $inquiries->links() }}
    </div>
</div>

@endsection
