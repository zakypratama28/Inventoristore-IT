@extends('layouts.admin')

@section('title', 'Stock Management')

@section('content')
<div class="stock-management">
    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-1"><i class="bi bi-box-seam me-2"></i>Stock Management</h2>
                <p class="text-muted">Monitor and manage product inventory</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.stock.export') }}" class="btn btn-outline-primary">
                    <i class="bi bi-download me-2"></i>Export CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary-subtle">
                    <i class="bi bi-box-seam text-primary"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ number_format($stats['total_products']) }}</h3>
                    <p class="stat-label">Total Products</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning-subtle">
                    <i class="bi bi-exclamation-triangle text-warning"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ number_format($stats['low_stock']) }}</h3>
                    <p class="stat-label">Low Stock</p>
                    <small class="text-muted">< 10 items</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger-subtle">
                    <i class="bi bi-x-circle text-danger"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ number_format($stats['out_of_stock']) }}</h3>
                    <p class="stat-label">Out of Stock</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon bg-success-subtle">
                    <i class="bi bi-cash-stack text-success"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">Rp {{ number_format($stats['total_stock_value']) }}</h3>
                    <p class="stat-label">Total Value</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.stock.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" 
                               placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available (≥10)</option>
                        <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>Low Stock (<10)</option>
                        <option value="out" {{ request('status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            {{-- Desktop Table --}}
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock Level</th>
                            <th>Price</th>
                            <th>Total Value</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-4">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                         class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <small class="text-muted">#{{ $product->id }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-bold {{ $product->stock == 0 ? 'text-danger' : ($product->stock < 10 ? 'text-warning' : 'text-success') }}">
                                            {{ $product->stock }}
                                        </span>
                                        @if($product->stock == 0)
                                            <span class="badge bg-danger">Out</span>
                                        @elseif($product->stock < 10)
                                            <span class="badge bg-warning">Low</span>
                                        @endif
                                    </div>
                                </td>
                                <td>Rp {{ number_format($product->price) }}</td>
                                <td>Rp {{ number_format($product->stock * $product->price) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" onclick="openStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})">
                                        <i class="bi bi-pencil-square"></i> Update
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="viewHistory({{ $product->id }})">
                                        <i class="bi bi-clock-history"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-3">No products found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="d-lg-none p-3">
                @foreach($products as $product)
                    <div class="product-card mb-3">
                        <div class="d-flex gap-3">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $product->name }}</h6>
                                <div class="mb-2">
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted d-block">Stock</small>
                                        <span class="fw-bold {{ $product->stock == 0 ? 'text-danger' : ($product->stock < 10 ? 'text-warning' : 'text-success') }}">
                                            {{ $product->stock }}
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">Value</small>
                                        <span class="fw-semibold">Rp {{ number_format($product->stock * $product->price) }}</span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-primary w-100" onclick="openStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})">
                                        <i class="bi bi-pencil-square me-1"></i> Update Stock
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="p-3 border-top">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Stock Update Modal --}}
<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i>Update Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h6 id="modalProductName" class="mb-2"></h6>
                    <div class="stock-display">
                        <small class="text-muted d-block">Current Stock</small>
                        <h2 id="modalCurrentStock" class="mb-0"></h2>
                    </div>
                </div>

                <form id="stockUpdateForm">
                    <input type="hidden" id="productId">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Stock Adjustment</label>
                        <div class="input-group input-group-lg">
                            <button type="button" class="btn btn-outline-secondary" onclick="adjustStock(-10)">-10</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="adjustStock(-1)">-1</button>
                            <input type="number" id="stockAdjustment" class="form-control text-center fw-bold" value="0">
                            <button type="button" class="btn btn-outline-secondary" onclick="adjustStock(1)">+1</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="adjustStock(10)">+10</button>
                        </div>
                    </div>

                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-info-circle me-2"></i>
                        <div>
                            New Stock: <strong id="newStockPreview">0</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Reason</label>
                        <select id="stockReason" class="form-select" required>
                            <option value="">Select reason...</option>
                            <option value="Restock">Restock / Incoming Stock</option>
                            <option value="Sale">Sold / Customer Purchase</option>
                            <option value="Damaged">Damaged / Defective</option>
                            <option value="Return">Customer Return</option>
                            <option value="Adjustment">Manual Adjustment</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateStock()">
                    <i class="bi bi-check-circle me-2"></i>Update Stock
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Stat Cards */
.stat-card {
    background: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: var(--bs-body-color);
}

.stat-label {
    margin-bottom: 0;
    color: var(--bs-secondary);
    font-size: 0.875rem;
}

/* Product Card (Mobile) */
.product-card {
    background: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color);
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.2s ease;
}

.product-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

/* Stock Display in Modal */
.stock-display {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 12px;
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: fadeInUp 0.5s ease;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endpush

@push('scripts')
<script>
let currentStock = 0;
const stockModal = new bootstrap.Modal(document.getElementById('stockModal'));

function openStockModal(productId, productName, stock) {
    currentStock = stock;
    document.getElementById('productId').value = productId;
    document.getElementById('modalProductName').textContent = productName;
    document.getElementById('modalCurrentStock').textContent = stock;
    document.getElementById('stockAdjustment').value = 0;
    document.getElementById('stockReason').value = '';
    updateNewStockPreview();
    stockModal.show();
}

function adjustStock(amount) {
    const input = document.getElementById('stockAdjustment');
    input.value = parseInt(input.value || 0) + amount;
    updateNewStockPreview();
}

document.getElementById('stockAdjustment').addEventListener('input', updateNewStockPreview);

function updateNewStockPreview() {
    const adjustment = parseInt(document.getElementById('stockAdjustment').value || 0);
    const newStock = currentStock + adjustment;
    document.getElementById('newStockPreview').textContent = newStock;
}

async function updateStock() {
    const productId = document.getElementById('productId').value;
    const adjustment = parseInt(document.getElementById('stockAdjustment').value || 0);
    const reason = document.getElementById('stockReason').value;

    if (!reason) {
        alert('Please select a reason for the stock adjustment');
        return;
    }

    if (adjustment === 0) {
        alert('Please enter a stock adjustment amount');
        return;
    }

    try {
        const response = await fetch(`/admin/stock/${productId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ adjustment, reason })
        });

        const data = await response.json();

        if (data.success) {
            stockModal.hide();
            location.reload();
        } else {
            alert(data.message || 'Failed to update stock');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

async function viewHistory(productId) {
    // TODO: Implement history modal
    alert('Stock history for product #' + productId);
}
</script>
@endpush
@endsection
