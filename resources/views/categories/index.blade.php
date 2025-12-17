@extends('layouts.inventory')

@section('title', 'Kategori')
@section('page-title', 'Daftar Kategori')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body px-0 pb-2">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="px-3 pt-3">
                    <div class="alert alert-success py-2 mb-3">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="px-3 pt-3 d-flex justify-content-between align-items-center">
                <p class="text-muted small mb-0">
                    Kelola daftar kategori barang. Kategori yang dibuat di sini akan muncul di form
                    <strong>Tambah / Ubah Barang</strong>.
                </p>

                {{-- Tombol Tambah Kategori --}}
                <button type="button" class="btn btn-primary-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createCategoryModal">
                    Tambah Kategori
                </button>
            </div>

            <div class="table-responsive p-0 mt-3">
                <table class="table table-modern mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3 text-uppercase text-secondary text-xxs">No</th>
                            <th class="text-uppercase text-secondary text-xxs">Nama Kategori</th>
                            <th class="text-uppercase text-secondary text-xxs text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $i => $category)
                            <tr>
                                <td class="ps-3 align-middle">
                                    <span class="text-xs">{{ $i + 1 }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="fw-semibold text-sm">{{ $category->name }}</span>
                                </td>
                                <td class="align-middle text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal-{{ $category->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteCategoryModal-{{ $category->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            {{-- EDIT MODAL --}}
                            <div class="modal fade" id="editCategoryModal-{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <form method="POST" action="{{ route('categories.update', $category->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-semibold mb-1">Edit Kategori</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pt-3">
                                                <div class="mb-3">
                                                    <label class="form-label small text-muted mb-1">Nama Kategori</label>
                                                    <input type="text" name="name" class="form-control form-control-sm"
                                                        value="{{ $category->name }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light border rounded-pill px-3" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-3">
                                                    Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- DELETE MODAL --}}
                            <div class="modal fade" id="deleteCategoryModal-{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body text-center py-4">
                                                <div class="text-danger mb-3">
                                                    <i class="bi bi-exclamation-circle display-1"></i>
                                                </div>
                                                <h5 class="fw-bold mb-2">Hapus Kategori?</h5>
                                                <p class="text-muted small mb-4">
                                                    Anda yakin ingin menghapus kategori <strong>{{ $category->name }}</strong>?<br>
                                                    Tindakan ini tidak dapat dibatalkan.
                                                </p>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                        Ya, Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <span class="text-muted small">
                                        Belum ada kategori. Tambahkan kategori pertama.
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Kategori --}}
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold mb-1">Tambah Kategori Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-3">
                        <div class="mb-3">
                            <label class="form-label small text-muted mb-1">Nama Kategori</label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                placeholder="Contoh: Komponen Komputer" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light border rounded-pill px-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-3">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
