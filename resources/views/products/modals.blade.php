{{-- CREATE MODAL --}}
<div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold">Tambah Barang Baru</h5>
                        <small class="text-muted">Isi detail barang yang ingin ditambahkan ke gudang.</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-medium small text-uppercase">Foto Produk</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small text-uppercase">Nama Barang</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Asus ROG Strix" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small text-uppercase">Kategori</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small text-uppercase">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" placeholder="0" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small text-uppercase">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat produk..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- LOOP FOR PRODUCT SPECIFIC MODALS --}}
@foreach ($products as $product)

    {{-- SHOW MODAL --}}
    <div class="modal fade" id="showProductModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">Detail Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="rounded-3 mb-3 border shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-box fs-1 text-secondary opacity-50"></i>
                        </div>
                    @endif
                    <h4 class="fw-bold text-dark mb-1">{{ $product->name }}</h4>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill mb-3">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>
                    <h3 class="fw-bold text-primary mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                    <p class="text-muted small px-4">{{ $product->description }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editProductModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="modal-header border-bottom-0 pb-0">
                        <div>
                            <h5 class="modal-title fw-bold">Edit Barang</h5>
                            <small class="text-muted">Perbarui informasi barang.</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-medium small text-uppercase">Foto Produk</label>
                                @if($product->image_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->image_path) }}" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium small text-uppercase">Nama Barang</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small text-uppercase">Kategori</label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small text-uppercase">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium small text-uppercase">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="deleteProductModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center py-5">
                        <div class="mb-3 text-danger">
                            <i class="bi bi-exclamation-circle" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Hapus Barang?</h5>
                        <p class="text-muted px-4 mb-4">
                            Anda yakin ingin menghapus <strong>{{ $product->name }}</strong>? 
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endforeach
