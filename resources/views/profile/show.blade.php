@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row g-4">
        {{-- Main Profile Card --}}
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white border-0 py-4 rounded-top-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" 
                                 style="width: 64px; height: 64px;">
                                <i class="bi bi-person-fill fs-2 text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                            <p class="mb-0 opacity-75"><i class="bi bi-envelope me-2"></i>{{ $user->email }}</p>
                            <span class="badge bg-white bg-opacity-20 mt-2">
                                <i class="bi bi-shield-check me-1"></i>{{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Informasi Pribadi Section --}}
                        <div class="mb-5">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-person-badge text-primary me-2"></i>
                                Informasi Pribadi
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" 
                                        class="form-control bg-light border-0 rounded-3 @error('name') is-invalid @enderror" 
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" 
                                        class="form-control bg-light border-0 rounded-3 @error('email') is-invalid @enderror" 
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-telephone-fill"></i></span>
                                        <input type="text" name="phone" 
                                            class="form-control bg-light border-0 rounded-end @error('phone') is-invalid @enderror" 
                                            value="{{ old('phone', $user->phone) }}" 
                                            placeholder="contoh: 081234567890">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Alamat Section --}}
                        <div class="mb-5">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                Alamat Pengiriman
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Alamat Lengkap</label>
                                    <textarea name="address" rows="3" 
                                        class="form-control bg-light border-0 rounded-3 @error('address') is-invalid @enderror" 
                                        placeholder="Jl. Contoh No. 123, RT 01/RW 02, Kelurahan...">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Kota/Kabupaten</label>
                                    <input type="text" name="city" 
                                        class="form-control bg-light border-0 rounded-3 @error('city') is-invalid @enderror" 
                                        value="{{ old('city', $user->city) }}" 
                                        placeholder="contoh: Jakarta Selatan">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Provinsi</label>
                                    <input type="text" name="province" 
                                        class="form-control bg-light border-0 rounded-3 @error('province') is-invalid @enderror" 
                                        value="{{ old('province', $user->province) }}" 
                                        placeholder="contoh: DKI Jakarta">
                                    @error('province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Kode Pos</label>
                                    <input type="text" name="postal_code" 
                                        class="form-control bg-light border-0 rounded-3 @error('postal_code') is-invalid @enderror" 
                                        value="{{ old('postal_code', $user->postal_code) }}" 
                                        placeholder="contoh: 12345" 
                                        maxlength="10">
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Security Section --}}
                        <div class="mb-4">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-shield-lock text-primary me-2"></i>
                                Keamanan Akun
                            </h5>
                            
                            <div class="alert alert-warning border-0 d-flex align-items-center mb-3">
                                <i class="bi bi-info-circle me-2 fs-5"></i>
                                <small>Kosongkan jika tidak ingin mengubah password</small>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Password Saat Ini</label>
                                    <input type="password" name="current_password" 
                                        class="form-control bg-light border-0 rounded-3 @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Password Baru</label>
                                    <input type="password" name="new_password" 
                                        class="form-control bg-light border-0 rounded-3 @error('new_password') is-invalid @enderror">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-medium text-muted small text-uppercase ls-1">Konfirmasi Password</label>
                                    <input type="password" name="new_password_confirmation" 
                                        class="form-control bg-light border-0 rounded-3">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('home') }}" class="btn btn-light rounded-pill px-4">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Additional Info Card --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-4">
                    <div class="row text-center g-3">
                        <div class="col-md-4">
                            <div class="p-3">
                                <i class="bi bi-bag-check text-primary fs-2 mb-2"></i>
                                <h6 class="fw-bold mb-0">Total Pesanan</h6>
                                <p class="text-muted mb-0">{{ $user->orders()->count() ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 border-start">
                            <div class="p-3">
                                <i class="bi bi-clock-history text-success fs-2 mb-2"></i>
                                <h6 class="fw-bold mb-0">Bergabung Sejak</h6>
                                <p class="text-muted mb-0">{{ $user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 border-start">
                            <div class="p-3">
                                <i class="bi bi-shield-check text-info fs-2 mb-2"></i>
                                <h6 class="fw-bold mb-0">Status Akun</h6>
                                <span class="badge bg-success">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .ls-1 {
        letter-spacing: 0.5px;
    }
    .form-control:focus {
        background-color: #fff;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
</style>
@endpush
@endsection
