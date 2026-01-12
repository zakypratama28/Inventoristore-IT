@extends('layouts.inventory')
@section('title', 'Daftar Pelanggan')
@section('page-title', 'Data Pelanggan')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        {{-- Search --}}
        <div class="bg-light bg-opacity-50 p-3 mx-3 rounded-3 my-3 border">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label small text-muted fw-bold text-uppercase ls-1">Pencarian Pelanggan</label>
                    <div class="input-group bg-white rounded-3 border">
                        <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control border-0 shadow-none ps-0" 
                            placeholder="Cari nama atau email..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-lg-2 d-grid">
                    <button type="submit" class="btn btn-secondary w-100">
                        Cari
                    </button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Email</th>
                        <th>Bergabung</th>
                        <th>Role</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-initial rounded-circle bg-primary bg-opacity-10 text-primary fw-bold me-3 px-3 py-2 small">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <span class="fw-medium text-dark">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $customer->email }}</td>
                        <td class="text-muted">{{ $customer->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">
                                User
                            </span>
                        </td>
						<td class="text-end pe-4">
							<div class="d-flex justify-content-end gap-2">
								<button type="button" class="btn btn-sm btn-info text-white rounded-pill px-3"
									onclick="showCustomerDetail(
                                        '{{ addslashes($customer->name) }}', 
                                        '{{ addslashes($customer->email) }}', 
                                        '{{ $customer->phone ?? '-' }}', 
                                        '{{ addslashes($customer->address ?? '-') }}', 
                                        '{{ addslashes($customer->city ?? '-') }}', 
                                        '{{ addslashes($customer->postal_code ?? '-') }}', 
                                        '{{ addslashes($customer->province ?? '-') }}', 
                                        '{{ $customer->created_at->format('d M Y') }}'
                                    )">
									Lihat Detail
								</button>
								<form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
									onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 position-relative z-index-1">
										<i class="bi bi-trash"></i>
									</button>
								</form>
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="5" class="text-center py-5 text-muted">Belum ada pelanggan.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-footer bg-white border-0 py-3">
		{{ $customers->links() }}
	</div>
</div>

{{-- Modal Detail Pelanggan --}}
<div class="modal fade" id="customerDetailModal" tabindex="-1" aria-labelledby="customerDetailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-4 border-0 shadow">
			<div class="modal-header border-0 pb-0">
				<h5 class="modal-title fw-bold" id="customerDetailModalLabel">Detail Pelanggan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-4 text-center">
				<div class="avatar-initial rounded-circle bg-primary bg-opacity-10 text-primary fw-bold mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
					<span id="modalCustomerInitial"></span>
				</div>
				<h4 class="fw-bold mb-1" id="modalCustomerName"></h4>
				<p class="text-muted mb-4" id="modalCustomerEmail"></p>

				<div class="row g-3 text-start mt-3">
                    <div class="col-12">
                        <div class="bg-light rounded-3 p-3">
                            <small class="text-uppercase fw-bold text-muted small d-block mb-1">Nomor Telepon</small>
                            <div class="fw-medium text-dark" id="modalCustomerPhone"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bg-light rounded-3 p-3">
                            <small class="text-uppercase fw-bold text-muted small d-block mb-1">Alamat Lengkap</small>
                            <div class="fw-medium text-dark" id="modalCustomerAddress"></div>
                            <div class="mt-2 small text-muted">
                                <span id="modalCustomerCity"></span>, <span id="modalCustomerProvince"></span> <span id="modalCustomerPostal"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bg-light rounded-3 p-3">
                            <small class="text-uppercase fw-bold text-muted small d-block mb-1">Bergabung Sejak</small>
                            <div class="fw-medium text-dark" id="modalCustomerJoined"></div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="modal-footer border-0 pt-0 justify-content-center">
				<button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<script>
	function showCustomerDetail(name, email, phone, address, city, postal, province, joined) {
		document.getElementById('modalCustomerName').textContent = name;
		document.getElementById('modalCustomerEmail').textContent = email;
        document.getElementById('modalCustomerPhone').textContent = phone;
        document.getElementById('modalCustomerAddress').textContent = address;
        document.getElementById('modalCustomerCity').textContent = city;
        document.getElementById('modalCustomerPostal').textContent = postal;
        document.getElementById('modalCustomerProvince').textContent = province;
		document.getElementById('modalCustomerJoined').textContent = joined;
		document.getElementById('modalCustomerInitial').textContent = name.charAt(0).toUpperCase();
		
		var myModal = new bootstrap.Modal(document.getElementById('customerDetailModal'));
		myModal.show();
	}
</script>
@endsection
