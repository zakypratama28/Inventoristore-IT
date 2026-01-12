@extends('layouts.inventory')

@section('title', 'Review Management')
@section('page-title', 'Manajemen Review')

@section('content')
<div class="row g-4">
    {{-- Statistics Cards --}}
    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 140px;">
                    <div class="card-body text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small mb-1 text-white text-uppercase fw-bold" style="opacity: 0.9; letter-spacing: 1px;">Total Reviews</div>
                                <h3 class="fw-bold mb-0 text-white">{{ number_format($stats['total']) }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="bi bi-chat-left-text fs-4 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 140px;">
                    <div class="card-body text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small mb-1 text-white text-uppercase fw-bold" style="opacity: 0.9; letter-spacing: 1px;">Rata-rata Rating</div>
                                <h3 class="fw-bold mb-0 text-white">{{ $stats['average_rating'] }}/5.0</h3>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="bi bi-star-fill fs-4 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); min-height: 140px;">
                    <div class="card-body text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small mb-1 text-white text-uppercase fw-bold" style="opacity: 0.9; letter-spacing: 1px;">5 Bintang</div>
                                <h3 class="fw-bold mb-0 text-white">{{ number_format($stats['five_star']) }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="bi bi-emoji-smile fs-4 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); min-height: 140px;">
                    <div class="card-body text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small mb-1 text-white text-uppercase fw-bold" style="opacity: 0.9; letter-spacing: 1px;">1 Bintang</div>
                                <h3 class="fw-bold mb-0 text-white">{{ number_format($stats['one_star']) }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="bi bi-emoji-frown fs-4 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Daftar Review</h5>
                        <small class="text-muted">Kelola semua review produk dari customer</small>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0">
                {{-- Filters --}}
                <div class="bg-light bg-opacity-50 p-3 mx-3 rounded-3 mb-3 border">
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="row g-3 align-items-end">
                        <div class="col-lg-4">
                            <label class="form-label small text-muted fw-bold text-uppercase">Cari Review</label>
                            <div class="input-group bg-white rounded-3 border">
                                <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control border-0 shadow-none ps-0" 
                                       placeholder="Cari teks review..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label small text-muted fw-bold text-uppercase">Produk</label>
                            <select name="product_id" class="form-select">
                                <option value="">Semua Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label small text-muted fw-bold text-uppercase">Rating</label>
                            <select name="rating" class="form-select">
                                <option value="">Semua Rating</option>
                                @foreach([5,4,3,2,1] as $rating)
                                    <option value="{{ $rating }}" {{ request('rating') == $rating ? 'selected' : '' }}>
                                        {{ $rating }} ⭐
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 d-grid">
                            <button type="submit" class="btn btn-secondary">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Reviews Table/Cards --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">User</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produk</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rating</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Review</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-2" 
                                             style="width: 36px; height: 36px; font-size: 0.875rem;">
                                            {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm fw-bold">{{ $review->user->name ?? 'Anonymous' }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $review->user->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0 text-sm fw-semibold">{{ $review->product->name }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $review->product->category->name ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill" style="color: {{ $i <= $review->rating ? '#FFD700' : '#e0e0e0' }}; font-size: 0.875rem;"></i>
                                        @endfor
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary mt-1">{{ $review->rating }}/5</span>
                                </td>
                                <td>
                                    <p class="mb-0 text-sm" style="max-width: 300px;">{{ Str::limit($review->review_text, 100) }}</p>
                                </td>
                                <td class="text-center">
                                    <span class="text-xs text-secondary">{{ $review->created_at->format('d M Y') }}</span>
                                    <br>
                                    <span class="text-xs text-muted">{{ $review->created_at->format('H:i') }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger delete-review-btn" 
                                            data-review-id="{{ $review->id }}"
                                            data-user-name="{{ $review->user->name ?? 'Anonymous' }}"
                                            title="Hapus Review">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-chat-left-text-fill fs-1 d-block mb-2 opacity-50"></i>
                                    Tidak ada review ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white border-0 py-3">
                {{ $reviews->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Delete Review
document.querySelectorAll('.delete-review-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        const reviewId = this.dataset.reviewId;
        const userName = this.dataset.userName;
        
        if (!confirm(`Hapus review dari ${userName}?`)) return;
        
        try {
            const response = await fetch(`{{ url('/admin/reviews') }}/${reviewId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                alert(data.message);
                location.reload();
            } else {
                alert('Gagal menghapus review');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.text-xxs { font-size: 0.75rem; }
.table > :not(caption) > * > * { padding: 1rem 0.5rem; border-bottom-color: #f0f2f5; }
.bg-gradient { background-size: 200% 200%; animation: gradient 3s ease infinite; }
@keyframes gradient { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
</style>
@endpush
@endsection
