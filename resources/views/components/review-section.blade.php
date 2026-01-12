{{-- Modern Review Section Component --}}
@props(['product'])

@php
    $reviews = $product->reviews()->with('user')->latest()->get();
    $totalReviews = $reviews->count();
    $averageRating = $totalReviews > 0 ? $product->averageRating() : 0;
    
    // Calculate rating breakdown
    $ratingBreakdown = [
        5 => $reviews->where('rating', 5)->count(),
        4 => $reviews->where('rating', 4)->count(),
        3 => $reviews->where('rating', 3)->count(),
        2 => $reviews->where('rating', 2)->count(),
        1 => $reviews->where('rating', 1)->count(),
    ];
    
    $satisfactionRate = $totalReviews > 0 
        ? round(($ratingBreakdown[5] + $ratingBreakdown[4]) / $totalReviews * 100) 
        : 0;
@endphp

<div class="review-section mt-5">
    <h3 class="mb-4">{{ __('Ulasan Pembeli') }}</h3>

    {{-- Rating Overview --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-3 text-center border-end">
                    <div class="rating-overview">
                        <div class="display-3 fw-bold text-warning mb-2">
                            {{ number_format($averageRating, 1) }}
                            <span class="fs-4 text-muted">/ 5.0</span>
                        </div>
                        <div class="stars mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($averageRating))
                                    <i class="bi bi-star-fill text-warning fs-5"></i>
                                @elseif($i - $averageRating < 1)
                                    <i class="bi bi-star-half text-warning fs-5"></i>
                                @else
                                    <i class="bi bi-star text-warning fs-5"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted mb-1">{{ $satisfactionRate }}% pembeli merasa puas</p>
                        <p class="small text-muted">{{ $totalReviews }} rating • {{ $totalReviews }} ulasan</p>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="rating-breakdown ps-md-4">
                        @foreach($ratingBreakdown as $star => $count)
                            <div class="d-flex align-items-center mb-2">
                                <div class="star-label me-3" style="min-width: 80px;">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    <span class="fw-semibold">{{ $star }}</span>
                                </div>
                                <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                    <div class="progress-bar bg-warning" 
                                         style="width: {{ $totalReviews > 0 ? ($count / $totalReviews * 100) : 0 }}%">
                                    </div>
                                </div>
                                <span class="count text-muted" style="min-width: 40px; text-align: right;">
                                    ({{ $count }})
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters & Sort --}}
    <div class="review-filters mb-4">
        <div class="d-flex flex-wrap gap-2 mb-3">
            <button class="btn btn-outline-secondary active" data-filter="all">
                Semua
            </button>
            <button class="btn btn-outline-secondary" data-filter="with-photo">
                <i class="bi bi-camera me-1"></i> Dengan Foto & Video
            </button>
            @foreach([5,4,3,2,1] as $star)
                <button class="btn btn-outline-secondary" data-filter="rating-{{ $star }}">
                    {{ $star }} <i class="bi bi-star-fill text-warning"></i>
                </button>
            @endforeach
        </div>

        <div class="d-flex align-items-center gap-3">
            <label class="text-muted small">Urutkan:</label>
            <select class="form-select form-select-sm" style="width: auto;" id="reviewSort">
                <option value="latest">Paling Membantu</option>
                <option value="oldest">Terlama</option>
                <option value="highest">Rating Tertinggi</option>
                <option value="lowest">Rating Terendah</option>
            </select>
        </div>
    </div>

    {{-- Reviews List --}}
    <div class="reviews-list">
        @forelse($reviews as $review)
            <div class="review-item card border-0 border-bottom mb-3 pb-3" 
                 data-rating="{{ $review->rating }}"
                 data-has-photo="{{ $review->photos ? 'true' : 'false' }}">
                <div class="card-body p-0">
                    <div class="d-flex align-items-start mb-3">
                        <div class="review-avatar me-3">
                            @if($review->user->avatar)
                                <img src="{{ asset('storage/' . $review->user->avatar) }}" 
                                     alt="{{ $review->user->name }}" 
                                     class="rounded-circle"
                                     width="40" height="40">
                            @else
                                <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                     style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-0">{{ substr($review->user->name, 0, 1) }}***</h6>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">
                                    @if($review->created_at->diffInDays(now()) > 365)
                                        Lebih dari 1 tahun lalu
                                    @elseif($review->created_at->diffInMonths(now()) > 0)
                                        {{ $review->created_at->diffInMonths(now()) }} bulan lalu
                                    @else
                                        {{ $review->created_at->diffForHumans() }}
                                    @endif
                                </small>
                            </div>
                            <p class="mb-2">{{ $review->comment }}</p>
                            
                            {{-- Photo Attachments (if any) --}}
                            @if($review->photos)
                                <div class="review-photos d-flex gap-2 mb-2">
                                    @foreach(json_decode($review->photos) as $photo)
                                        <img src="{{ asset('storage/' . $photo) }}" 
                                             alt="Review photo" 
                                             class="review-photo-thumb"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer;">
                                    @endforeach
                                </div>
                            @endif

                            {{-- Review Actions --}}
                            @auth
                                @if($review->user_id === auth()->id())
                                    <div class="review-actions mt-2">
                                        <button class="btn btn-sm btn-outline-primary me-2" 
                                                onclick="editReview({{ $review->id }})">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteReview({{ $review->id }})">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-chat-quote text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">Belum ada ulasan untuk produk ini</p>
                @auth
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#reviewModal">
                        <i class="bi bi-star me-2"></i>Tulis Ulasan Pertama
                    </button>
                @endauth
            </div>
        @endforelse

        @if($reviews->count() >= 6)
            <div class="text-center mt-4">
                <button class="btn btn-outline-primary">
                    Lihat Lebih Banyak Ulasan
                </button>
            </div>
        @endif
    </div>

    {{-- Write Review Button (for authenticated users) --}}
    @auth
        @if($totalReviews > 0)
            <div class="text-center mt-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                    <i class="bi bi-star me-2"></i>Tulis Ulasan
                </button>
            </div>
        @endif
    @endauth
</div>

{{-- Review Modal --}}
@auth
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Tulis Ulasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reviews.store', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Rating Input --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Rating Produk</label>
                        <div class="rating-input">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star rating-star" data-rating="{{ $i }}" style="font-size: 2rem; cursor: pointer; color: #ddd;"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" required>
                    </div>

                    {{-- Comment Input --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ulasan Anda</label>
                        <textarea name="comment" class="form-control" rows="4" 
                                  placeholder="Ceritakan pengalaman Anda dengan produk ini..." required></textarea>
                    </div>

                    {{-- Photo Upload --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Produk (Opsional)</label>
                        <input type="file" class="form-control" name="photos[]" accept="image/*" multiple>
                        <small class="text-muted">Maksimal 5 foto</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

@push('scripts')
<script>
// Rating input stars
document.querySelectorAll('.rating-star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.dataset.rating;
        document.getElementById('ratingValue').value = rating;
        
        // Update star display
        document.querySelectorAll('.rating-star').forEach((s, index) => {
            if (index < rating) {
                s.classList.remove('bi-star');
                s.classList.add('bi-star-fill');
                s.style.color = '#ffc107';
            } else {
                s.classList.remove('bi-star-fill');
                s.classList.add('bi-star');
                s.style.color = '#ddd';
            }
        });
    });
    
    // Hover effect
    star.addEventListener('mouseenter', function() {
        const rating = this.dataset.rating;
        document.querySelectorAll('.rating-star').forEach((s, index) => {
            if (index < rating) {
                s.style.color = '#ffc107';
            }
        });
    });
});

document.querySelector('.rating-input').addEventListener('mouseleave', function() {
    const currentRating = document.getElementById('ratingValue').value || 0;
    document.querySelectorAll('.rating-star').forEach((s, index) => {
        if (index < currentRating) {
            s.style.color = '#ffc107';
        } else {
            s.style.color = '#ddd';
        }
    });
});

// Review filters
document.querySelectorAll('[data-filter]').forEach(btn => {
    btn.addEventListener('click', function() {
        // Update active button
        document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        const reviews = document.querySelectorAll('.review-item');
        
        reviews.forEach(review => {
            let show = true;
            
            if (filter === 'all') {
                show = true;
            } else if (filter === 'with-photo') {
                show = review.dataset.hasPhoto === 'true';
            } else if (filter.startsWith('rating-')) {
                const rating = filter.split('-')[1];
                show = review.dataset.rating === rating;
            }
            
            review.style.display = show ? 'block' : 'none';
        });
    });
});

// Delete review
function deleteReview(id) {
    if (confirm('Apakah Anda yakin ingin menghapus ulasan ini?')) {
        // Submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/reviews/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush

<style>
.review-section .card {
    transition: all 0.3s ease;
}

.rating-breakdown .progress {
    border-radius: 10px;
}

.rating-breakdown .progress-bar {
    border-radius: 10px;
    transition: width 0.5s ease;
}

.review-filters .btn {
    transition: all 0.2s ease;
}

.review-filters .btn.active {
    background: var(--bs-primary);
    color: white;
    border-color: var(--bs-primary);
}

.review-item {
    transition: all 0.3s ease;
}

.review-photo-thumb:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}
</style>
