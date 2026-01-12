@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div style="margin-top: 80px;">
    <div class="container py-5">
        <div class="row g-4">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    {{-- Featured Image --}}
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="w-100" style="max-height: 400px; object-fit: cover;" alt="{{ $post->title }}">
                    @endif
                    
                    <div class="card-body p-4 p-md-5">
                        {{-- Meta --}}
                        <div class="mb-3">
                            <span class="badge bg-primary-subtle text-primary rounded-pill me-2">{{ $post->category }}</span>
                            <span class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>{{ $post->published_at->format('d F Y') }}
                            </span>
                            <span class="text-muted small mx-2">•</span>
                            <span class="text-muted small">
                                <i class="bi bi-clock me-1"></i>{{ $post->read_time }} min read
                            </span>
                            <span class="text-muted small mx-2">•</span>
                            <span class="text-muted small">
                                <i class="bi bi-eye me-1"></i>{{ $post->views }} views
                            </span>
                        </div>

                        {{-- Title --}}
                        <h1 class="fw-bold mb-4">{{ $post->title }}</h1>
                        
                        {{-- Excerpt --}}
                        @if($post->excerpt)
                            <p class="lead text-muted border-start border-4 border-primary ps-3 mb-4">
                                {{ $post->excerpt }}
                            </p>
                        @endif

                        {{-- Author --}}
                        <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <span class="fw-bold">{{ substr($post->user->name ?? 'A', 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="fw-bold">{{ $post->user->name ?? 'Admin' }}</div>
                                <div class="small text-muted">Author</div>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="blog-content">
                            {!! $post->content !!}
                        </div>

                        {{-- Share Buttons --}}
                        <div class="mt-5 pt-4 border-top">
                            <h6 class="fw-bold mb-3">Bagikan Artikel:</h6>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="bi bi-facebook"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-outline-info">
                                    <i class="bi bi-twitter"></i> Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . route('blog.show', $post->slug)) }}" target="_blank" class="btn btn-outline-success">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Related Posts --}}
                @if($relatedPosts->count() > 0)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Artikel Terkait</h5>
                        @foreach($relatedPosts as $related)
                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <a href="{{ route('blog.show', $related->slug) }}" class="text-decoration-none">
                                <div class="d-flex gap-3">
                                    @if($related->featured_image)
                                        <img src="{{ asset('storage/' . $related->featured_image) }}" class="rounded" width="80" height="80" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; min-width: 80px;">
                                            <i class="bi bi-file-text text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1 small">{{ Str::limit($related->title, 60) }}</h6>
                                        <div class="small text-muted">
                                            <i class="bi bi-calendar3"></i> {{ $related->published_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Categories --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Kategori</h5>
                        <div class="d-flex flex-column gap-2">
                            @foreach(['Gaming', 'Gadgets', 'Smartphone', 'Tech', 'Review'] as $cat)
                                <a href="{{ route('blog.index', ['category' => $cat]) }}" class="btn btn-outline-primary text-start">
                                    {{ $cat }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.blog-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.blog-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
}

.blog-content h2, .blog-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: bold;
}

.blog-content p {
    margin-bottom: 1.5rem;
}

.blog-content ul, .blog-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.blog-content li {
    margin-bottom: 0.5rem;
}
</style>
@endsection
