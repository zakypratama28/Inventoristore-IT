@extends('layouts.app')

@section('title', 'Blog & Artikel')

@section('content')
<div style="margin-top: 80px;">
    {{-- Hero Section --}}
    <div class="bg-light py-5 mb-5 border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-3 text-dark">Blog & Artikel</h1>
                    <p class="lead mb-0 text-secondary">Informasi terkini seputar gaming, gadget, smartphone, dan teknologi</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        {{-- Category Filter --}}
        <div class="mb-4">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('blog.index') }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">
                    Semua
                </a>
                @foreach(['Gaming', 'Gadgets', 'Smartphone', 'Tech', 'Review'] as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat]) }}" class="btn {{ request('category') == $cat ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Blog Grid --}}
        <div class="row g-4">
            @forelse($posts as $post)
            <div class="col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100 hover-lift">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $post->title }}">
                    @else
                        <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-file-text text-white" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill">{{ $post->category }}</span>
                            <span class="text-muted small ms-2">
                                <i class="bi bi-calendar3"></i> {{ $post->published_at->format('d M Y') }}
                            </span>
                        </div>
                        
                        <h5 class="card-title fw-bold mb-2">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none stretched-link">
                                {{ $post->title }}
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted small mb-3">{{ Str::limit($post->excerpt, 100) }}</p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center small text-muted">
                            <span><i class="bi bi-eye"></i> {{ $post->views }} views</span>
                            <span><i class="bi bi-clock"></i> {{ $post->read_time }} min read</span>
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-file-text text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Belum Ada Artikel</h4>
                    <p class="text-muted">Artikel akan segera hadir</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
        <div class="mt-5">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.bg-gradient {
    background-size: 200% 200%;
    animation: gradient 5s ease infinite;
}

@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
</style>
@endsection
