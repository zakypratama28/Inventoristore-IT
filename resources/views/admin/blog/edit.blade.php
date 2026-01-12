@extends('layouts.inventory')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel Blog')

@section('content')
<form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
        {{-- Main Content --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Artikel</label>
                        <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $post->title) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ringkasan Singkat</label>
                        <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Konten Artikel</label>
                        <textarea name="content" id="content" class="form-control" rows="15">{{ old('content', $post->content) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Gambar Unggulan</h6>
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid rounded mb-3" style="max-height: 200px;">
                    @endif
                    <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                    <div id="image-preview" class="mt-3" style="display: none;">
                        <img src="" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Kategori</h6>
                    <select name="category" class="form-select" required>
                        <option value="Gaming" {{ old('category', $post->category) == 'Gaming' ? 'selected' : '' }}>Gaming</option>
                        <option value="Gadgets" {{ old('category', $post->category) == 'Gadgets' ? 'selected' : '' }}>Gadgets</option>
                        <option value="Smartphone" {{ old('category', $post->category) == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                        <option value="Tech" {{ old('category', $post->category) == 'Tech' ? 'selected' : '' }}>Tech</option>
                        <option value="Review" {{ old('category', $post->category) == 'Review' ? 'selected' : '' }}>Review</option>
                    </select>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Status Publikasi</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="status" id="draft" value="draft" {{ old('status', $post->status) == 'draft' ? 'checked' : '' }}>
                        <label class="form-check-label" for="draft"><strong>Draft</strong></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="published" value="published" {{ old('status', $post->status) == 'published' ? 'checked' : '' }}>
                        <label class="form-check-label" for="published"><strong>Publish</strong></label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg me-2"></i>Update Artikel
                </button>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">Batal</a>
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
    $('#content').summernote({height: 400});
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
