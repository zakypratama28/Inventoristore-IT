{{-- Wishlist Toggle Button Component --}}
@props(['productId', 'size' => 'md'])

@php
    $isInWishlist = false;
    if (Auth::check()) {
        $isInWishlist = Auth::user()->hasInWishlist($productId);
    }
    
    $sizeClasses = [
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg'
    ];
    
    $iconSizes = [
        'sm' => 'fs-6',
        'md' => 'fs-5',
        'lg' => 'fs-4'
    ];
@endphp

<button 
    type="button" 
    class="btn wishlist-toggle-btn {{ $sizeClasses[$size] }} {{ $isInWishlist ? 'active' : '' }}" 
    data-product-id="{{ $productId }}"
    data-in-wishlist="{{ $isInWishlist ? 'true' : 'false' }}"
    @guest
        onclick="alert('{{ __('messages.login_required') }}'); window.location.href='{{ route('login') }}';"
    @endguest
    title="{{ $isInWishlist ? __('messages.remove_from_wishlist') : __('messages.add_to_wishlist') }}">
    <i class="bi {{ $isInWishlist ? 'bi-heart-fill' : 'bi-heart' }} {{ $iconSizes[$size] }} wishlist-icon"></i>
</button>

<style>
.wishlist-toggle-btn {
    position: relative;
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid #e0e0e0;
    border-radius: 50%;
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
    cursor: pointer;
    padding: 0;
}

.wishlist-toggle-btn.btn-sm {
    width: 36px;
    height: 36px;
}

.wishlist-toggle-btn.btn-lg {
    width: 50px;
    height: 50px;
}

.wishlist-toggle-btn:hover {
    transform: scale(1.1);
    border-color: #e91e63;
    box-shadow: 0 4px 12px rgba(233, 30, 99, 0.3);
}

.wishlist-toggle-btn .wishlist-icon {
    color: var(--color-text);
    transition: all 0.3s ease;
}

.wishlist-toggle-btn.active .wishlist-icon,
.wishlist-toggle-btn:hover .wishlist-icon {
    color: #e91e63;
}

.wishlist-toggle-btn.active {
    background: rgba(233, 30, 99, 0.1);
    border-color: #e91e63;
}

/* Animation when toggling */
@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.3); }
    50% { transform: scale(1.1); }
}

.wishlist-toggle-btn.animating .wishlist-icon {
    animation: heartBeat 0.5s ease;
}

/* Dark mode support */
[data-theme="dark"] .wishlist-toggle-btn {
    background: rgba(30, 30, 30, 0.9);
    border-color: #444;
}

[data-theme="dark"] .wishlist-toggle-btn:hover {
    border-color: #e91e63;
}

/* Loading state */
.wishlist-toggle-btn.loading {
    pointer-events: none;
    opacity: 0.6;
}

.wishlist-toggle-btn.loading .wishlist-icon {
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

@auth
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wishlist toggle functionality
    const wishlistButtons = document.querySelectorAll('.wishlist-toggle-btn');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            const isInWishlist = this.dataset.inWishlist === 'true';
            const icon = this.querySelector('.wishlist-icon');
            
            // Add loading state
            this.classList.add('loading');
            
            try {
                let response;
                
                if (isInWishlist) {
                    // Remove from wishlist
                    response = await fetch(`/wishlist/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    });
                } else {
                    // Add to wishlist
                    response = await fetch('/wishlist', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ product_id: productId })
                    });
                }
                
                const data = await response.json();
                
                if (response.ok) {
                    // Toggle state
                    this.dataset.inWishlist = !isInWishlist;
                    this.classList.toggle('active');
                    
                    // Update icon
                    if (isInWishlist) {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                        this.title = '{{ __("messages.add_to_wishlist") }}';
                    } else {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                        this.title = '{{ __("messages.remove_from_wishlist") }}';
                    }
                    
                    // Heart beat animation
                    this.classList.add('animating');
                    setTimeout(() => this.classList.remove('animating'), 500);
                    
                    // Show toast notification (optional - if you have toast library)
                    if (typeof showToast !== 'undefined') {
                        showToast(data.message || 'Success', 'success');
                    }
                } else {
                    throw new Error(data.message || 'Failed to update wishlist');
                }
            } catch (error) {
                console.error('Wishlist toggle error:', error);
                alert('Failed to update wishlist. Please try again.');
            } finally {
                // Remove loading state
                this.classList.remove('loading');
            }
        });
    });
});
</script>
@endpush
@endauth
