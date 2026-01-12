@extends('layouts.admin')

@section('title', 'Landing Page Management')

@section('content')
<div class="landing-page-management">
    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-1"><i class="bi bi-palette me-2"></i>Landing Page Sections</h2>
                <p class="text-muted">Customize your homepage layout</p>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                    <i class="bi bi-plus-circle me-2"></i>Add Section
                </button>
            </div>
        </div>
    </div>

    {{-- Sections List --}}
    <div class="row">
        @forelse($sections as $section)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="section-card">
                    <div class="section-header">
                        <div class="d-flex align-items-center gap-2">
                            <span class="section-icon">
                                @switch($section->type)
                                    @case('hero')
                                        <i class="bi bi-badge-ad"></i>
                                        @break
                                    @case('features')
                                        <i class="bi bi-grid-3x3"></i>
                                        @break
                                    @case('products')
                                        <i class="bi bi-bag"></i>
                                        @break
                                    @case('promo')
                                        <i class="bi bi-megaphone"></i>
                                        @break
                                    @case('categories')
                                        <i class="bi bi-tags"></i>
                                        @break
                                    @default
                                        <i class="bi bi-square"></i>
                                @endswitch
                            </span>
                            <div>
                                <h6 class="mb-0">{{ ucfirst($section->type) }}</h6>
                                <small class="text-muted">Order: {{ $section->order }}</small>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   {{ $section->is_active ? 'checked' : '' }}
                                   onchange="toggleSection({{ $section->id }}, this.checked)">
                        </div>
                    </div>
                    
                    <div class="section-body">
                        @if($section->image_path)
                            <img src="{{ asset('storage/' . $section->image_path) }}" 
                                 alt="Section image" class="section-thumb mb-2">
                        @endif
                        
                        <h6 class="section-title">{{ $section->title }}</h6>
                        
                        @if($section->content)
                            <p class="section-content text-muted small">
                                {{ Str::limit($section->content, 80) }}
                            </p>
                        @endif
                    </div>
                    
                    <div class="section-footer">
                        <button class="btn btn-sm btn-outline-primary" 
                                onclick="editSection({{ $section->id }}, '{{ $section->type }}', '{{ $section->title }}', `{{ $section->content }}`)">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.landing.destroy', $section) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                    onclick="return confirm('Delete this section?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: var(--bs-secondary);"></i>
                    <h5 class="mt-3">No sections yet</h5>
                    <p class="text-muted">Create your first landing page section to get started</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                        <i class="bi bi-plus-circle me-2"></i>Add Section
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Add Section Modal --}}
<div class="modal fade" id="addSectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="bi bi-plus-square me-2"></i>Add New Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.landing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Section Type</label>
                            <select name="type" class="form-select" required>
                                <option value="">Choose type...</option>
                                <option value="hero">Hero Banner</option>
                                <option value="features">Features Grid</option>
                                <option value="products">Product Showcase</option>
                                <option value="promo">Promo Banner</option>
                                <option value="categories">Category Grid</option>
                                <option value="testimonials">Testimonials</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Content</label>
                            <textarea name="content" class="form-control" rows="3"></textarea>
                            <small class="text-muted">Description or subtitle for this section</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Background Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended: 1920x1080px</small>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                <label class="form-check-label" for="isActive">
                                    Activate immediately
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Create Section
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Section Modal --}}
<div class="modal fade" id="editSectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editSectionForm" enctype="multipart/form-data">
                    <input type="hidden" id="editSectionId">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Section Type</label>
                            <input type="text" id="editSectionType" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" id="editSectionTitle" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Content</label>
                            <textarea id="editSectionContent" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Update Image</label>
                            <input type="file" id="editSectionImage" class="form-control" accept="image/*">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveSection()">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.section-card {
    background: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.section-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.section-header {
    padding: 1rem;
    background: var(--bs-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.section-body {
    padding: 1rem;
}

.section-thumb {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
}

.section-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.section-content {
    line-height: 1.5;
}

.section-footer {
    padding: 1rem;
    border-top: 1px solid var(--bs-border-color);
    display: flex;
    gap: 0.5rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.section-card {
    animation: fadeInUp 0.5s ease;
}
</style>
@endpush

@push('scripts')
<script>
const editModal = new bootstrap.Modal(document.getElementById('editSectionModal'));

function editSection(id, type, title, content) {
    document.getElementById('editSectionId').value = id;
    document.getElementById('editSectionType').value = type;
    document.getElementById('editSectionTitle').value = title;
    document.getElementById('editSectionContent').value = content;
    editModal.show();
}

async function saveSection() {
    const id = document.getElementById('editSectionId').value;
    const formData = new FormData();
    formData.append('title', document.getElementById('editSectionTitle').value);
    formData.append('content', document.getElementById('editSectionContent').value);
    
    const imageInput = document.getElementById('editSectionImage');
    if (imageInput.files.length > 0) {
        formData.append('image', imageInput.files[0]);
    }

    try {
        const response = await fetch(`/admin/landing/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT',
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            editModal.hide();
            location.reload();
        } else {
            alert(data.message || 'Failed to update section');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

async function toggleSection(id, isActive) {
    try {
        const response = await fetch(`/admin/landing/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT',
            },
            body: JSON.stringify({ is_active: isActive })
        });

        if (!response.ok) {
            throw new Error('Failed to toggle section');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update section status');
    }
}
</script>
@endpush
@endsection
