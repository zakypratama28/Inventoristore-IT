@extends('layouts.inventory')

@section('content')
<div class="container-fluid px-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Manajemen FAQ</h4>
            <p class="text-muted small mb-0">Kelola pertanyaan yang sering diajukan</p>
        </div>
        <a href="{{ route('admin.faq.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah FAQ
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FAQ List --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="40%">Pertanyaan</th>
                            <th width="35%">Jawaban</th>
                            <th width="8%" class="text-center">Urutan</th>
                            <th width="7%" class="text-center">Status</th>
                            <th width="5%" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr>
                                <td>{{ $faqs->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $faq->question }}</td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;">
                                        {{ Str::limit(strip_tags($faq->answer), 100) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $faq->order }}</span>
                                </td>
                                <td class="text-center">
                                    @if($faq->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.faq.edit', $faq) }}" 
                                           class="btn btn-outline-primary" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                onclick="deleteFaq({{ $faq->id }})"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-question-circle" style="font-size: 3rem;"></i>
                                    <p class="mt-2 mb-0">Belum ada FAQ</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $faqs->links() }}
    </div>
</div>

<script>
function deleteFaq(id) {
    if (confirm('Yakin ingin menghapus FAQ ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/faq/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
