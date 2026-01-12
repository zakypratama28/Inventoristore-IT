@extends('layouts.inventory')

@section('title', 'Blog Management')
@section('page-title', 'Artikel & Blog')

@section('content')
<div class="row g-4">
    {{-- Header --}}
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1">Kelola Artikel Blog</h5>
                <p class="text-muted small mb-0">Buat dan kelola artikel tentang gaming, gadget, dan teknologi</p>
            </div>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i>Buat Artikel Baru
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 180px;">
            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 120px; margin-top: -20px; margin-right: -20px;">
                <i class="bi bi-file-text text-white"></i>
            </div>
            <div class="card-body text-white position-relative p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small mb-1 text-uppercase fw-bold text-white" style="letter-spacing: 1px; opacity: 0.9;">Total Artikel</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 2.5rem;">{{ $posts->total() }}</h3>
                        <div class="small mt-2 text-white" style="opacity: 0.85;">
                            <i class="bi bi-graph-up-arrow me-1"></i>Semua Kategori
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-file-text fs-3 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                {{-- Filters --}}
                <div class="bg-light bg-opacity-50 p-3 mx-3 rounded-3 my-3 border">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-lg-4">
                            <label class="form-label small fw-bold text-uppercase">Cari Artikel</label>
                            <input type="text" name="search" class="form-control" placeholder="Judul atau isi..." value="{{ request('search') }}">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label small fw-bold text-uppercase">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="Gaming" {{ request('category') == 'Gaming' ? 'selected' : '' }}>Gaming</option>
                                <option value="Gadgets" {{ request('category') == 'Gadgets' ? 'selected' : '' }}>Gadgets</option>
                                <option value="Smartphone" {{ request('category') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                                <option value="Tech" {{ request('category') == 'Tech' ? 'selected' : '' }}>Tech</option>
                                <option value="Review" {{ request('category') == 'Review' ? 'selected' : '' }}>Review</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label small fw-bold text-uppercase">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-lg-3 d-grid">
                            <button type="submit" class="btn btn-secondary"><i class="bi bi-funnel me-1"></i> Filter</button>
                        </div>
                    </form>
                </div>

                {{-- Blog Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Artikel</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Views</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="rounded me-3" width="60" height="60" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ Str::limit($post->title, 50) }}</h6>
                                            <small class="text-muted">{{ Str::limit($post->excerpt, 60) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary">{{ $post->category }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $post->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted"><i class="bi bi-eye me-1"></i>{{ $post->views }}</span>
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">{{ $post->created_at->format('d M Y') }}</small>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Preview">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post->slug) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-slug="{{ $post->slug }}" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-file-text fs-1 d-block mb-2 opacity-50"></i>
                                    Belum ada artikel blog
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        if (!confirm('Hapus artikel ini?')) return;
        
        const postSlug = this.dataset.slug;
        const baseUrl = '{{ url('/') }}';
        
        try {
            const response = await fetch(`${baseUrl}/admin/blog/${postSlug}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                alert('Artikel berhasil dihapus!');
                location.reload();
            } else {
                alert(data.message || 'Gagal menghapus artikel');
            }
        } catch (error) {
            console.error('Delete error:', error);
            alert('Gagal menghapus artikel');
        }
    });
});
</script>
@endpush
@endsection
