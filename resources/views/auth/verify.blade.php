@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-lock-fill fs-1"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Verifikasi Akun</h3>
                        <p class="text-muted small">Masukkan 6 digit kode yang telah kami kirimkan ke email:<br>
                           <span class="fw-bold text-dark">{{ auth()->user()->email }}</span>
                        </p>
                    </div>

                    @if (session('warning'))
                        <div class="alert alert-warning border-0 small mb-4 shadow-sm">
                            <i class="bi bi-info-circle-fill me-2"></i> {{ session('warning') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success border-0 small mb-4 shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 small mb-4 shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verify.store') }}" id="otp-form">
                        @csrf
                        <div class="d-flex justify-content-between mb-4 gap-2">
                            <input type="text" maxlength="1" class="otp-input form-control text-center fw-bold fs-3 rounded-3 border-2" name="code_box[]" required autofocus>
                            <input type="text" maxlength="1" class="otp-input form-control text-center fw-bold fs-3 rounded-3 border-2" name="code_box[]" required>
                            <input type="text" maxlength="1" class="otp-input form-control text-center fw-bold fs-3 rounded-3 border-2" name="code_box[]" required>
                            <input type="text" maxlength="1" class="otp-input form-control text-center fw-bold fs-3 rounded-3 border-2" name="code_box[]" required>
                            <input type="text" maxlength="1" class="otp-input form-control text-center fw-bold fs-3 rounded-3 border-2" name="code_box[]" required>
                            <input type="text" maxlength="1" class="otp-input form-control text-center fw-bold fs-3 rounded-3 border-2" name="code_box[]" required>
                        </div>
                        <input type="hidden" name="code" id="verification_code">

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm py-3 fw-bold">
                                Verifikasi Sekarang
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">Tidak menerima kode? 
                            <span id="countdown-text" class="fw-bold">Tunggu <span id="timer">60</span> detik</span>
                            <form action="{{ route('verify.resend') }}" method="POST" class="d-inline" id="resend-form" style="display: none !important;">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-primary fw-bold text-decoration-none small" style="vertical-align: baseline;">Kirim Ulang</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .otp-input {
        width: 100%;
        height: 60px;
        transition: all 0.3s ease;
    }
    .otp-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        transform: translateY(-2px);
    }
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.otp-input');
    const form = document.getElementById('otp-form');
    const hiddenInput = document.getElementById('verification_code');

    inputs.forEach((input, index) => {
        // Handle input typing
        input.addEventListener('input', function(e) {
            if (this.value.length === 1) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
            updateHiddenInput();
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const data = e.clipboardData.getData('text').slice(0, 6);
            if (!/^\d+$/.test(data)) return;

            data.split('').forEach((char, i) => {
                if (inputs[i]) {
                    inputs[i].value = char;
                }
            });
            updateHiddenInput();
            inputs[Math.min(data.length, inputs.length - 1)].focus();
        });
    });

    function updateHiddenInput() {
        hiddenInput.value = Array.from(inputs).map(i => i.value).join('');
    }

    // Countdown Timer Logic
    let timeLeft = 60;
    const timerElement = document.getElementById('timer');
    const countdownText = document.getElementById('countdown-text');
    const resendForm = document.getElementById('resend-form');

    const countdown = setInterval(() => {
        timeLeft--;
        if (timerElement) timerElement.innerText = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(countdown);
            if (countdownText) countdownText.style.display = 'none';
            if (resendForm) resendForm.style.setProperty('display', 'inline', 'important');
        }
    }, 1000);

    form.addEventListener('submit', function(e) {
        updateHiddenInput();
        if (hiddenInput.value.length !== 6) {
            e.preventDefault();
            alert('Silakan masukkan 6 digit kode secara lengkap.');
        }
    });
});
</script>
@endpush
