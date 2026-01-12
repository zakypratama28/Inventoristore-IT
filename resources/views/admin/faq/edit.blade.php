@extends('layouts.inventory')

@section('content')
<div class="container-fluid px-4">
    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('admin.faq.index') }}" class="btn btn-link text-decoration-none ps-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">Edit FAQ</h4>
        <p class="text-muted small mb-0">Perbarui pertanyaan dan jawaban</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.faq.update', $faq) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Question --}}
                        <div class="mb-4">
                            <label for="question" class="form-label fw-semibold">
                                Pertanyaan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('question') is-invalid @enderror" 
                                   id="question" 
                                   name="question" 
                                   value="{{ old('question', $faq->question) }}"
                                   required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Answer --}}
                        <div class="mb-4">
                            <label for="answer" class="form-label fw-semibold">
                                Jawaban <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('answer') is-invalid @enderror" 
                                      id="answer" 
                                      name="answer" 
                                      rows="8"
                                      required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Gunakan Enter untuk baris baru</small>
                        </div>

                        {{-- Order --}}
                        <div class="mb-4">
                            <label for="order" class="form-label fw-semibold">
                                Urutan Tampilan
                            </label>
                            <input type="number" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order"
                                   value="{{ old('order', $faq->order) }}"
                                   min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Semakin kecil angka, semakin atas posisinya</small>
                        </div>

                        {{-- Active Status --}}
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active"
                                       {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Aktif (Tampilkan di halaman publik)
                                </label>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Update FAQ
                            </button>
                            <a href="{{ route('admin.faq.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
