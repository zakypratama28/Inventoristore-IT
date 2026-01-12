@extends('layouts.inventory')

@section('title', 'Buat Artikel Baru')
@section('page-title', 'Buat Artikel Blog')

@section('content')
<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        {{-- Main Content --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="Contoh: 10 Laptop Gaming Terbaik 2026" value="{{ old('title') }}" required>
                        @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- Excerpt --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Ringkasan Singkat</label>
                        <textarea name="excerpt" class="form-control" rows="3" placeholder="Deskripsi singkat artikel (maks 300 karakter)...">{{ old('excerpt') }}</textarea>
                        @error('excerpt')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- Content --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Konten Artikel <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" class="form-control" rows="15">{{ old('content') }}</textarea>
                        @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Featured Image --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Gambar Unggulan</h6>
                    <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                    <div id="image-preview" class="mt-3" style="display: none;">
                        <img src="" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                    @error('featured_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Category --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Kategori <span class="text-danger">*</span></h6>
                    <select name="category" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Gaming" {{ old('category') == 'Gaming' ? 'selected' : '' }}>Gaming</option>
                        <option value="Gadgets" {{ old('category') == 'Gadgets' ? 'selected' : '' }}>Gadgets</option>
                        <option value="Smartphone" {{ old('category') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                        <option value="Tech" {{ old('category') == 'Tech' ? 'selected' : '' }}>Tech</option>
                        <option value="Review" {{ old('category') == 'Review' ? 'selected' : '' }}>Review</option>
                    </select>
                    @error('category')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Status Publikasi <span class="text-danger">*</span></h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="status" id="draft" value="draft" {{ old('status', 'draft') == 'draft' ? 'checked' : '' }}>
                        <label class="form-check-label" for="draft">
                            <strong>Draft</strong> - Simpan sebagai draft
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="published" value="published" {{ old('status') == 'published' ? 'checked' : '' }}>
                        <label class="form-check-label" for="published">
                            <strong>Publish</strong> - Terbitkan sekarang
                        </label>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg me-2"></i>Simpan Artikel
                </button>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg me-2"></i>Batal
                </a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Summernote
    $('#content').summernote({
        height: 400,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Image preview
    $('#featured_image').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview img').attr('src', e.target.result);
                $('#image-preview').show();
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
