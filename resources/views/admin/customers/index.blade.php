@extends('layouts.inventory')
@section('title', 'Daftar Pelanggan')
@section('page-title', 'Data Pelanggan')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
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
                            <button class="btn btn-sm btn-light border rounded-pill" disabled>
                                Lihat Detail
                            </button>
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
@endsection
