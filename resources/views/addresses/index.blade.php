@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                {{ __('messages.addresses.title') }}
            </h2>
            <p class="text-muted">{{ __('messages.addresses.subtitle') }}</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal">
                <i class="bi bi-plus-circle me-2"></i>{{ __('messages.addresses.add_new') }}
            </button>
        </div>
    </div>

    @if($addresses->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-geo-alt display-1 text-muted mb-3"></i>
                        <h4>{{ __('messages.addresses.empty') }}</h4>
                        <p class="text-muted">{{ __('messages.addresses.empty_subtitle') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($addresses as $address)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm {{ $address->is_default ? 'border-primary border-2' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1">{{ $address->label }}</h5>
                                    @if($address->is_default)
                                        <span class="badge bg-primary">{{ __('messages.addresses.default') }}</span>
                                    @endif
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">
                                                <i class="bi bi-pencil me-2"></i>{{ __('messages.edit') }}
                                            </button>
                                        </li>
                                        @if(!$address->is_default)
                                            <li>
                                                <form action="{{ route('addresses.set-default', $address) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-check-circle me-2"></i>{{ __('messages.addresses.set_default') }}
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('addresses.destroy', $address) }}" method="POST" 
                                                  onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>{{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <p class="mb-1"><strong>{{ $address->name }}</strong></p>
                            <p class="mb-1">
                                <i class="bi bi-telephone me-2"></i>{{ $address->phone }}
                            </p>
                            <p class="mb-1">{{ $address->address }}</p>
                            <p class="mb-0 text-muted">
                                {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.addresses.add_new') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.label') }}</label>
                        <input type="text" name="label" class="form-control" required 
                               placeholder="{{ __('messages.addresses.label_placeholder') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.phone') }}</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.address') }}</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.addresses.city') }}</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.addresses.postal_code') }}</label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.province') }}</label>
                        <input type="text" name="province" class="form-control" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_default" class="form-check-input" id="isDefault" value="1">
                        <label class="form-check-label" for="isDefault">
                            {{ __('messages.addresses.set_as_default') }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Address Modals -->
@foreach($addresses as $address)
<div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.addresses.edit') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('addresses.update', $address) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.label') }}</label>
                        <input type="text" name="label" class="form-control" required value="{{ $address->label }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.name') }}</label>
                        <input type="text" name="name" class="form-control" required value="{{ $address->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.phone') }}</label>
                        <input type="text" name="phone" class="form-control" required value="{{ $address->phone }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.address') }}</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ $address->address }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.addresses.city') }}</label>
                            <input type="text" name="city" class="form-control" required value="{{ $address->city }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.addresses.postal_code') }}</label>
                            <input type="text" name="postal_code" class="form-control" required value="{{ $address->postal_code }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.addresses.province') }}</label>
                        <input type="text" name="province" class="form-control" required value="{{ $address->province }}">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_default" class="form-check-input" id="isDefaultEdit{{ $address->id }}" value="1" {{ $address->is_default ? 'checked' : '' }}>
                        <label class="form-check-label" for="isDefaultEdit{{ $address->id }}">
                            {{ __('messages.addresses.set_as_default') }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
