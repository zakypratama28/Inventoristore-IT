@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="user-management">
    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-1"><i class="bi bi-people me-2"></i>User Management</h2>
                <p class="text-muted">Manage users, roles, and permissions</p>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary-subtle">
                    <i class="bi bi-people text-primary"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ number_format($stats['total']) }}</h3>
                    <p class="stat-label">Total Users</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger-subtle">
                    <i class="bi bi-shield-check text-danger"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ number_format($stats['admins']) }}</h3>
                    <p class="stat-label">Admins</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning-subtle">
                    <i class="bi bi-person-badge text-warning"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ number_format($stats['staff']) }}</h3>
                    <p class="stat-label">Staff</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon bg-success-subtle">
                    <i class="bi bi-person-check text-success"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ number_format($stats['customers']) }}</h3>
                    <p class="stat-label">Customers</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" 
                               placeholder="Search by name or email..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            {{-- Desktop Table --}}
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <small class="text-muted">#{{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role === 'staff')
                                        <span class="badge bg-warning">Staff</span>
                                    @else
                                        <span class="badge bg-primary">Customer</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="bi bi-check-circle me-1"></i>Verified
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">
                                            <i class="bi bi-clock me-1"></i>Pending
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people" style="font-size: 3rem;"></i>
                                    <p class="mt-3">No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="d-lg-none p-3">
                @foreach($users as $user)
                    <div class="user-card mb-3">
                        <div class="d-flex gap-3">
                            <div class="user-avatar-large">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $user->name }}</h6>
                                <p class="text-muted small mb-2">{{ $user->email }}</p>
                                <div class="d-flex gap-2 mb-2">
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role === 'staff')
                                        <span class="badge bg-warning">Staff</span>
                                    @else
                                        <span class="badge bg-primary">Customer</span>
                                    @endif
                                    
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success-subtle text-success">Verified</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-primary flex-grow-1" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete user?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                <div class="p-3 border-top">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Edit User Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="bi bi-person-gear me-2"></i>Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="userId">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" id="userName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" id="userEmail" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select id="userRole" class="form-select" required>
                            <option value="customer">Customer</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveUser()">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.stat-card {
    background: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-label {
    margin-bottom: 0;
    color: var(--bs-secondary);
    font-size: 0.875rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.user-avatar-large {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.5rem;
}

.user-card {
    background: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color);
    border-radius: 12px;
    padding: 1rem;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.stat-card {
    animation: fadeInUp 0.5s ease;
}
</style>
@endpush

@push('scripts')
<script>
const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));

function editUser(id, name, email, role) {
    document.getElementById('userId').value = id;
    document.getElementById('userName').value = name;
    document.getElementById('userEmail').value = email;
    document.getElementById('userRole').value = role;
    editModal.show();
}

async function saveUser() {
    const userId = document.getElementById('userId').value;
    const data = {
        name: document.getElementById('userName').value,
        email: document.getElementById('userEmail').value,
        role: document.getElementById('userRole').value,
    };

    try {
        const response = await fetch(`/admin/users/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            editModal.hide();
            location.reload();
        } else {
            alert(result.message || 'Failed to update user');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}
</script>
@endpush
@endsection
