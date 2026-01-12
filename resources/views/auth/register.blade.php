@extends('layouts.app')

@section('content')
<div class="register-page">
    <div class="container-fluid p-0 min-vh-100 d-flex align-items-center">
        <!-- Background with gradient -->
        <div class="auth-background"></div>
        
        <div class="container position-relative">
            <div class="row justify-content-center">
                <!-- Register Card -->
                <div class="col-lg-11 col-xl-10">
                    <div class="auth-card shadow-lg">
                        <div class="row g-0">
                            <!-- Left Side - Branding -->
                            <div class="col-lg-5 auth-card-left">
                                <div class="auth-branding">
                                    <img src="{{ asset('material-dashboard/assets/iconigg.svg') }}" alt="IGG Store" width="60" class="mb-4">
                                    <h4 class="fw-bold text-white mb-2">Selamat Datang di<br>IGG Store</h4>
                                    <p class="text-white-50 small mb-3">Destinasi premium untuk gadget & produk gaming Anda</p>
                                    
                                    <div class="benefit-item">
                                        <i class="bi bi-shield-check me-3"></i>
                                        <div>
                                            <h6 class="text-white mb-1">Belanja Aman</h6>
                                            <small class="text-white-50">Data Anda dilindungi dengan keamanan tingkat enterprise</small>
                                        </div>
                                    </div>
                                    
                                    <div class="benefit-item">
                                        <i class="bi bi-truck me-3"></i>
                                        <div>
                                            <h6 class="text-white mb-1">Pengiriman Cepat</h6>
                                            <small class="text-white-50">Produk dikirim dengan cepat ke alamat Anda</small>
                                        </div>
                                    </div>
                                    
                                    <div class="benefit-item">
                                        <i class="bi bi-star-fill me-3"></i>
                                        <div>
                                            <h6 class="text-white mb-1">Kualitas Premium</h6>
                                            <small class="text-white-50">100% produk asli dengan garansi</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Register Form -->
                            <div class="col-lg-7 auth-card-right">
                                <div class="auth-form-wrapper">
                                    <div class="text-center mb-4">
                                        <h4 class="fw-bold mb-2">Buat Akun</h4>
                                        <p class="text-muted small">Bergabunglah dengan ribuan pelanggan yang puas</p>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Oops!</strong> Mohon perbaiki kesalahan di bawah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                <i class="bi bi-person me-2"></i>Nama Lengkap
                            </label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control modern-input @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap Anda"
                                   required 
                                   autocomplete="name" 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-2"></i>Alamat Email
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control modern-input @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="your@email.com"
                                   required 
                                   autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Kami akan mengirim kode verifikasi ke email ini
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-2"></i>Password
                            </label>
                            <div class="input-group">
                                <input id="password" 
                                       type="password" 
                                       class="form-control modern-input @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Buat password yang kuat"
                                       required 
                                       autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted" id="passwordStrengthText">Minimal 8 karakter</small>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                <i class="bi bi-lock-fill me-2"></i>Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <input id="password_confirmation" 
                                       type="password" 
                                       class="form-control modern-input" 
                                       name="password_confirmation" 
                                       placeholder="Masukkan ulang password Anda"
                                       required 
                                       autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye" id="toggleConfirmPasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary modern-btn" id="registerBtn">
                                <span class="btn-text">
                                    <i class="bi bi-person-plus me-2"></i>Buat Akun
                                </span>
                                <span class="btn-loader d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Membuat akun...
                                </span>
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">
                                    Masuk <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Register Page Styles - Card Layout */
.register-page {
    font-family: 'Outfit', sans-serif;
}

/* Background */
.auth-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: 0;
}

.auth-background::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 30px 30px;
    animation: moveBackground 20s linear infinite;
}

@keyframes moveBackground {
    0% { transform: translate(0, 0); }
    100% { transform: translate(30px, 30px); }
}

/* Auth Card Container */
.auth-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    position: relative;
    z-index: 1;
}

/* Left Side - Branding */
.auth-card-left {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem 1.5rem;
    display: flex;
    align-items: center;
}

.auth-branding {
    width: 100%;
}

.auth-branding img {
    width: 50px;
}

.benefit-item {
    display: flex;
    align-items: start;
    margin-bottom: 0.75rem;
    padding: 0.625rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    backdrop-filter: blur(10px);
}

.benefit-item i {
    font-size: 1.1rem;
    color: white;
    flex-shrink: 0;
}

.benefit-item h6 {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.benefit-item small {
    font-size: 0.75rem;
}

/* Right Side - Form */
.auth-card-right {
    background: var(--color-bg, white);
    padding: 1.5rem 1.75rem;
}

.auth-form-wrapper {
    width: 100%;
    max-width: 100%;
}

.modern-input {
    border: 2px solid var(--color-border, #e5e7eb);
    border-radius: 10px;
    padding: 0.625rem 0.875rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: var(--color-surface, white);
    color: var(--color-text, #000);
}

.modern-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: var(--color-surface, white);
}

.modern-btn {
    border-radius: 10px;
    padding: 0.7rem 1.25rem;
    font-weight: 600;
    font-size: 0.95rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.modern-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.modern-btn:hover::before {
    left: 100%;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

.modern-btn:active {
    transform: translateY(0);
}

/* Password Strength */
.password-strength .progress-bar {
    transition: all 0.3s ease;
}

.password-strength .progress-bar.weak {
    background-color: #dc3545;
    width: 33%;
}

.password-strength .progress-bar.medium {
    background-color: #ffc107;
    width: 66%;
}

.password-strength .progress-bar.strong {
    background-color: #28a745;
    width: 100%;
}

/* Mobile Responsive */
@media (max-width: 991px) {
    .auth-card-left {
        display: none;
    }
    
    .auth-card-right {
        padding: 2rem 1.5rem;
    }
    
    .auth-card {
        margin: 1rem;
    }
}

/* Form Animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.auth-card {
    animation: slideInUp 0.5s ease-out;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            togglePasswordIcon.classList.toggle('bi-eye');
            togglePasswordIcon.classList.toggle('bi-eye-slash');
        });
    }

    // Toggle Confirm Password Visibility
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const toggleConfirmPasswordIcon = document.getElementById('toggleConfirmPasswordIcon');

    if (toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener('click', function() {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            toggleConfirmPasswordIcon.classList.toggle('bi-eye');
            toggleConfirmPasswordIcon.classList.toggle('bi-eye-slash');
        });
    }

    // Password Strength Indicator
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordStrengthText');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            let text = '';

            if (value.length >= 8) strength++;
            if (value.match(/[a-z]+/)) strength++;
            if (value.match(/[A-Z]+/)) strength++;
            if (value.match(/[0-9]+/)) strength++;
            if (value.match(/[$@#&!]+/)) strength++;

            strengthBar.classList.remove('weak', 'medium', 'strong');

            if (strength <= 2) {
                strengthBar.classList.add('weak');
                text = 'Password lemah';
            } else if (strength <= 4) {
                strengthBar.classList.add('medium');
                text = 'Password sedang';
            } else {
                strengthBar.classList.add('strong');
                text = 'Password kuat!';
            }

            strengthText.textContent = value.length > 0 ? text : 'Minimal 8 karakter';
        });
    }

    // Form Submit Loading State
    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');

    if (registerForm) {
        registerForm.addEventListener('submit', function() {
            const btnText = registerBtn.querySelector('.btn-text');
            const btnLoader = registerBtn.querySelector('.btn-loader');
            
            if (btnText && btnLoader) {
                btnText.classList.add('d-none');
                btnLoader.classList.remove('d-none');
                registerBtn.disabled = true;
            }
        });
    }
});
</script>
@endpush
@endsection
