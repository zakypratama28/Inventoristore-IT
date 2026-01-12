@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-lock-fill text-primary" style="font-size: 3rem;"></i>
                        <h3 class="mt-3 fw-bold">Forgot Password?</h3>
                        <p class="text-muted">Enter your email address and we'll send you a link to reset your password</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}"
                                   required 
                                   autofocus
                                   placeholder="your@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-envelope me-2"></i>Send Reset Link
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i>Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
