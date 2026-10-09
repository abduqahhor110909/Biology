@extends('layouts.app')

@section('content')
<section class="section" style="padding-top: 40px; background: #f8fafc;">
    <div class="container" style="max-width: 900px;">
        <!-- Breadcrumb -->
        <div style="margin-bottom: 24px; font-size: 0.9rem; color: #64748b;">
            <a href="{{ route('home') }}" style="color: #059669; font-weight: 600;">Bosh sahifa</a> &bull;
            <a href="{{ route('home') }}#articles" style="color: #059669; font-weight: 600;">Maqolalar</a> &bull;
            <span>{{ $article->category->name ?? 'Biologiya' }}</span>
        </div>

        <article style="background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.04);">
            <!-- Badge & Meta -->
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 20px;">
                <span class="cat-badge" style="font-size: 0.85rem; padding: 6px 14px;">{{ $article->category->name ?? 'Biologiya' }}</span>
                <span style="font-size: 0.85rem; color: #64748b;"><i class="bi bi-clock"></i> {{ $article->read_time }}</span>
                <span style="font-size: 0.85rem; color: #64748b;"><i class="bi bi-eye"></i> {{ number_format($article->views_count) }} marta o'qildi</span>
                <span style="font-size: 0.85rem; color: #64748b;"><i class="bi bi-calendar3"></i> {{ $article->created_at->format('d.m.Y') }}</span>
            </div>

            <h1 style="font-size: 2.3rem; font-weight: 800; color: #0f172a; line-height: 1.25; margin-bottom: 24px;">
                {{ $article->title }}
            </h1>

            @if($article->image)
            <div style="border-radius: 16px; overflow: hidden; margin-bottom: 30px; max-height: 420px;">
                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            @endif

            <div style="font-size: 1.12rem; line-height: 1.85; color: #334155;">
                {!! $article->content !!}
            </div>

            <!-- Social Share Bar -->
            <div style="margin-top: 40px; padding-top: 24px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="font-weight: 700; color: #1e293b;">Ushbu maqolani ulashing:</div>
                <div class="social-links">
                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="social-btn tg" title="Telegramda ulashish">
                        <i class="bi bi-telegram"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="social-btn" style="background: #1877f2;" title="Facebookda ulashish">
                        <i class="bi bi-facebook"></i>
                    </a>
                </div>
            </div>
        </article>

        <!-- Related articles -->
        @if($relatedArticles->count() > 0)
        <div style="margin-top: 60px;">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 24px;">Mavzuga doir boshqa maqolalar</h3>
            <div class="articles-grid">
                @foreach($relatedArticles as $rel)
                <div class="article-card">
                    <div class="article-body">
                        <div class="article-meta">
                            <span><i class="bi bi-clock"></i> {{ $rel->read_time }}</span>
                        </div>
                        <h4 class="article-title" style="font-size: 1.1rem;">
                            <a href="{{ route('article.show', $rel->slug) }}">{{ $rel->title }}</a>
                        </h4>
                        <p class="article-excerpt">{{ Str::limit($rel->excerpt, 100) }}</p>
                        <a href="{{ route('article.show', $rel->slug) }}" class="article-read-link">
                            O'qish <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
