{{-- Cart Sidebar Dropdown Component --}}
<div class="cart-sidebar" id="cartSidebar">
    {{-- Overlay --}}
    <div class="cart-sidebar-overlay" onclick="closeCartSidebar()"></div>
    
    {{-- Sidebar Content --}}
    <div class="cart-sidebar-content">
        {{-- Header --}}
        <div class="cart-sidebar-header">
            <h5 class="mb-0">
                <i class="bi bi-cart3 me-2"></i>
                Keranjang 
                <span class="badge bg-primary rounded-pill ms-2" id="cartSidebarCount">0</span>
            </h5>
            <button type="button" class="btn-close" onclick="closeCartSidebar()"></button>
        </div>

        {{-- Cart Items --}}
        <div class="cart-sidebar-body" id="cartSidebarItems">
            <div class="text-center py-5" id="emptyCartMessage">
                <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Keranjang Anda kosong</p>
                <button class="btn btn-primary btn-sm" onclick="closeCartSidebar()">
                    Mulai Belanja
                </button>
            </div>
        </div>

        {{-- Footer --}}
        <div class="cart-sidebar-footer" id="cartSidebarFooter" style="display: none;">
            <div class="total-section mb-3 pb-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Subtotal</span>
                    <h5 class="mb-0 fw-bold" id="cartSidebarSubtotal">Rp 0</h5>
                </div>
            </div>
            <div class="action-buttons d-grid gap-2">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary" onclick="closeCartSidebar()">
                    <i class="bi bi-eye me-2"></i>Lihat Keranjang
                </a>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                    <i class="bi bi-credit-card me-2"></i>Checkout
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Cart Sidebar Overlay */
.cart-sidebar {
    position: fixed;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    pointer-events: none;
    transition: all 0.3s ease;
}

.cart-sidebar.active {
    pointer-events: all;
}

.cart-sidebar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(2px);
}

.cart-sidebar.active .cart-sidebar-overlay {
    opacity: 1;
}

/* Sidebar Content */
.cart-sidebar-content {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    max-width: 420px;
    height: 100%;
    background: var(--bs-body-bg);
    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.cart-sidebar.active .cart-sidebar-content {
    transform: translateX(0);
}

/* Header */
.cart-sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--bs-border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--bs-body-bg);
}

.cart-sidebar-header h5 {
    color: var(--bs-body-color);
}

/* Body */
.cart-sidebar-body {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
}

.cart-sidebar-body::-webkit-scrollbar {
    width: 6px;
}

.cart-sidebar-body::-webkit-scrollbar-thumb {
    background: var(--bs-border-color);
    border-radius: 10px;
}

/* Cart Item */
.cart-item-card {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color);
    border-radius: 12px;
    margin-bottom: 0.75rem;
    transition: all 0.2s ease;
}

.cart-item-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.cart-item-image {
    width: 70px;
    height: 70px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-details {
    flex: 1;
    min-width: 0;
}

.cart-item-name {
    font-size: 0.9rem;
    font-weight: 500;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 0.5rem;
    color: var(--bs-body-color);
}

.cart-item-price {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bs-primary);
    margin-bottom: 0.5rem;
}

.cart-item-quantity {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.cart-item-remove {
    background: none;
    border: none;
    color: var(--bs-danger);
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    transition: all 0.2s ease;
}

.cart-item-remove:hover {
    background: rgba(var(--bs-danger-rgb), 0.1);
    border-radius: 4px;
}

/* Footer */
.cart-sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--bs-border-color);
    background: var(--bs-body-bg);
}

/* Responsive */
@media (max-width: 576px) {
    .cart-sidebar-content {
        max-width: 100%;
    }
}

/* Animation for item removal */
@keyframes slideOut {
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.cart-item-card.removing {
    animation: slideOut 0.3s ease forwards;
}
</style>

@push('scripts')
<script>
// Cart Sidebar Functions
let cartSidebarData = [];

function openCartSidebar() {
    document.getElementById('cartSidebar').classList.add('active');
    document.body.style.overflow = 'hidden';
    loadCartSidebarData();
}

function closeCartSidebar() {
    document.getElementById('cartSidebar').classList.remove('active');
    document.body.style.overflow = '';
}

async function loadCartSidebarData() {
    try {
        const response = await fetch('/api/cart/items', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            cartSidebarData = data.items;
            renderCartSidebar();
        }
    } catch (error) {
        console.error('Failed to load cart:', error);
    }
}

function renderCartSidebar() {
    const itemsContainer = document.getElementById('cartSidebarItems');
    const emptyMessage = document.getElementById('emptyCartMessage');
    const footer = document.getElementById('cartSidebarFooter');
    const countBadge = document.getElementById('cartSidebarCount');
    const subtotalEl = document.getElementById('cartSidebarSubtotal');
    
    if (cartSidebarData.length === 0) {
        emptyMessage.style.display = 'block';
        footer.style.display = 'none';
        countBadge.textContent = '0';
        return;
    }
    
    emptyMessage.style.display = 'none';
    footer.style.display = 'block';
    
    let total = 0;
    let html = '';
    
    cartSidebarData.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        html += `
            <div class="cart-item-card" data-item-id="${item.id}">
                <div class="cart-item-image">
                    <img src="${item.image || '/images/default-product.png'}" alt="${item.name}">
                </div>
                <div class="cart-item-details">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">
                        ${item.quantity} × Rp ${formatNumber(item.price)}
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Rp ${formatNumber(itemTotal)}</span>
                        <button class="cart-item-remove" onclick="removeFromCartSidebar(${item.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    itemsContainer.innerHTML = html;
    countBadge.textContent = cartSidebarData.length;
    subtotalEl.textContent = 'Rp ' + formatNumber(total);
}

async function removeFromCartSidebar(itemId) {
    const itemCard = document.querySelector(`[data-item-id="${itemId}"]`);
    itemCard.classList.add('removing');
    
    setTimeout(async () => {
        try {
            const response = await fetch(`/cart/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });
            
            if (response.ok) {
                cartSidebarData = cartSidebarData.filter(item => item.id != itemId);
                renderCartSidebar();
                updateCartBadge();
            }
        } catch (error) {
            console.error('Failed to remove item:', error);
            itemCard.classList.remove('removing');
        }
    }, 300);
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function updateCartBadge() {
    const mainBadge = document.getElementById('cartBadge');
    if (mainBadge) {
        mainBadge.textContent = cartSidebarData.length;
    }
}

// Auto-open cart on hover (desktop only)
if (window.innerWidth > 768) {
    let hoverTimeout;
    const cartLink = document.getElementById('cartLink');
    
    if (cartLink) {
        cartLink.addEventListener('mouseenter', () => {
            hoverTimeout = setTimeout(() => {
                openCartSidebar();
            }, 500);
        });
        
        cartLink.addEventListener('mouseleave', () => {
            clearTimeout(hoverTimeout);
        });
    }
}

// Click to toggle
document.getElementById('cartLink')?.addEventListener('click', (e) => {
    e.preventDefault();
    const sidebar = document.getElementById('cartSidebar');
    if (sidebar.classList.contains('active')) {
        closeCartSidebar();
    } else {
        openCartSidebar();
    }
});

// Close on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeCartSidebar();
    }
});
</script>
@endpush
