@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="fw-bold mb-0">Pesanan Saya</h3>
                <div>
                    <span class="text-muted">Total Pesanan:</span>
                    <span class="fw-bold text-dark">{{ $orders->total() }}</span>
                </div>
            </div>

            @forelse($orders as $order)
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    {{-- Order Header --}}
                    <div class="card-header bg-light border-bottom bg-opacity-50 py-3 px-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <div class="d-flex gap-4 small text-muted text-uppercase fw-bold ls-1">
                                    <div>
                                        <div class="mb-1">Tanggal Order</div>
                                        <div class="text-dark">{{ $order->created_at->format('d M Y') }}</div>
                                    </div>
                                    <div>
                                        <div class="mb-1">Total</div>
                                        <div class="text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                                    </div>
                                    <div>
                                        <div class="mb-1">Kode Pesanan</div>
                                        <div class="text-dark">{{ $order->code }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <span class="text-muted small">Order #{{ $order->code }}</span>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-medium">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Body --}}
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3 mb-md-0">
                                    <div class="me-4 position-relative">
                                        @php
                                            $badgeClass = match($order->status) {
                                                'completed' => 'success',
                                                'paid' => 'info',
                                                'pending' => 'warning',
                                                'cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }} rounded-pill px-3 py-2 text-uppercase ls-1">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ $order->created_at->isoFormat('dddd, D MMMM Y') }}
                                        </h6>
                                        <p class="text-muted small mb-0">
                                            {{ $order->items->count() }} Barang
                                        </p>
                                    </div>
                                </div>
                                
                                {{-- Product Previews (First 3) --}}
                                <div class="d-flex gap-2 mt-3">
                                    @foreach($order->items->take(3) as $item)
                                        <div class="border rounded-3 p-1" style="width: 60px; height: 60px;">
                                            @if($item->product && $item->product->image_url)
                                                <img src="{{ asset($item->product->image_url) }}" class="w-100 h-100 rounded-2" style="object-fit: cover;" title="{{ $item->product->name }}">
                                            @else
                                                <div class="w-100 h-100 bg-light rounded-2 d-flex align-items-center justify-content-center text-muted">
                                                    <i class="bi bi-box small"></i>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <div class="border rounded-3 p-1 bg-light d-flex align-items-center justify-content-center text-muted small fw-bold" style="width: 60px; height: 60px;">
                                            +{{ $order->items->count() - 3 }}
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                @if($order->status === 'pending')
                                    <button class="btn btn-primary rounded-pill px-4 shadow-sm w-100 w-md-auto">
                                        Bayar Sekarang
                                    </button>
                                @elseif($order->status === 'completed')
                                    <div class="d-flex gap-2 justify-content-md-end">
                                        <a href="#" class="btn btn-outline-primary rounded-pill px-4">
                                            Beli Lagi
                                        </a>
                                        <button type="button" class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $order->id }}">
                                            <i class="bi bi-star-fill me-1"></i> Beri Review
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-bag-x text-muted opacity-25" style="font-size: 5rem;"></i>
                    </div>
                    <h5 class="fw-bold">Belum ada pesanan</h5>
                    <p class="text-muted mb-4">Anda belum melakukan transaksi apapun.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4">
                        Mulai Belanja
                    </a>
                </div>
            @endforelse

            {{-- Review Modals - One for each completed order --}}
            @foreach($orders as $order)
                @if($order->status === 'completed')
                    <div class="modal fade" id="reviewModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-gradient-primary text-white">
                                    <h5 class="modal-title">
                                        <i class="bi bi-star-fill me-2"></i>Beri Review Produk
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted mb-4">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Pilih produk yang ingin Anda review dari pesanan ini
                                    </p>

                                    @foreach($order->items as $item)
                                        @php
                                            // Check if already reviewed
                                            $existingReview = \App\Models\Review::where('user_id', auth()->id())
                                                                ->where('product_id', $item->product_id)
                                                                ->where('order_id', $order->id)
                                                                ->first();
                                        @endphp
                                        
                                        <div class="product-review-item mb-4 p-3 border rounded {{ $existingReview ? 'bg-light' : '' }}">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product && $item->product->image_url)
                                                            <img src="{{ asset($item->product->image_url) }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 class="rounded me-3"
                                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">{{ $item->product->name ?? 'Produk tidak tersedia' }}</h6>
                                                            <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                                    @if($existingReview)
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle me-1"></i>Sudah Direview ({{ $existingReview->rating }} ⭐)
                                                        </span>
                                                    @else
                                                        <button type="button" 
                                                                class="btn btn-primary btn-sm rounded-pill"
                                                                data-bs-toggle="collapse" 
                                                                data-bs-target="#reviewForm{{ $order->id }}_{{ $item->id }}">
                                                            <i class="bi bi-pencil me-1"></i>Tulis Review
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            @if(!$existingReview)
                                                <div class="collapse mt-3" id="reviewForm{{ $order->id }}_{{ $item->id }}">
                                                    <form action="{{ route('orders.reviews.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Rating</label>
                                                            <div class="star-rating" data-form-id="reviewForm{{ $order->id }}_{{ $item->id }}">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <input type="radio" id="star{{ $i }}_{{ $order->id }}_{{ $item->id }}" name="rating" value="{{ $i }}" required>
                                                                    <label for="star{{ $i }}_{{ $order->id }}_{{ $item->id }}">
                                                                        <i class="bi bi-star-fill"></i>
                                                                    </label>
                                                                @endfor
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="comment{{ $order->id }}_{{ $item->id }}" class="form-label fw-semibold">
                                                                Komentar (Optional)
                                                            </label>
                                                            <textarea class="form-control" 
                                                                      id="comment{{ $order->id }}_{{ $item->id }}"
                                                                      name="comment" 
                                                                      rows="3" 
                                                                      placeholder="Bagaimana pengalaman Anda dengan produk ini?"
                                                                      maxlength="1000"></textarea>
                                                            <small class="text-muted">Maksimal 1000 karakter</small>
                                                        </div>

                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="bi bi-send me-1"></i>Kirim Review
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
