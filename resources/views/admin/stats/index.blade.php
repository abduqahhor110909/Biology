@extends('layouts.admin')

@section('title', 'Statistika Hisoblagichlari')

@section('content')

<div class="admin-card" style="max-width: 900px;">
    <div class="card-header-flex">
        <div>
            <h3>Bosh Sahifadagi Statistika Hisoblagichlari</h3>
            <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0;">
                Hero seksiyasining tagida joylashgan 4 ta yashil ko'rsatkichlar (masalan: 4000+, 3500+, 1500+, 5500+) ni bu yerdan o'zgartirishingiz mumkin.
            </p>
        </div>
    </div>

    <form action="{{ route('admin.stats.update') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            @foreach($stats as $st)
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
                <div style="font-weight: 700; color: #065f46; margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between;">
                    <span>{{ $st->sort_order }}-Hisoblagich</span>
                    <span style="font-size: 1.2rem; color: #15803d; font-weight: 900;">{{ $st->number }}{{ $st->suffix }}</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Raqam Qiymati</label>
                        <input type="text" name="counters[{{ $st->id }}][number]" class="form-control" value="{{ $st->number }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Qo'shimcha Belgi</label>
                        <input type="text" name="counters[{{ $st->id }}][suffix]" class="form-control" value="{{ $st->suffix ?? '+' }}" placeholder="+ yoki %">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Nomi / Tavsifi</label>
                    <input type="text" name="counters[{{ $st->id }}][label]" class="form-control" value="{{ $st->label }}" required>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 28px;">
            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 28px;">
                <i class="bi bi-check-lg"></i> Hisoblagichlarni Saqlash
            </button>
        </div>
    </form>
</div>

@endsection
