@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Müştərilər</h1>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
        Yeni Müştəri Əlavə Et
    </button>
    <form method="GET" action="{{ route('customers.index') }}" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Axtar: Şirkət adı, telefon, email" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="responsible_person" class="form-select">
                <option value="">Cavabdeh Şəxsə görə</option>
                @foreach($customers->pluck('responsible_person')->unique() as $responsible_person)
                    @if($responsible_person)
                        <option value="{{ $responsible_person }}" {{ request('responsible_person') == $responsible_person ? 'selected' : '' }}>
                            {{ $responsible_person }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="position" class="form-select">
                <option value="">Vəzifəyə görə</option>
                @foreach($customers->pluck('position')->unique() as $position)
                    @if($position)
                        <option value="{{ $position }}" {{ request('position') == $position ? 'selected' : '' }}>
                            {{ $position }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Axtar</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Şirkət Adı</th>
                <th>Telefon</th>
                <th>Email</th>
                <th>Cavabdeh Şəxs</th>
                <th>Vəzifə</th>
                <th>Əməliyyatlar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr>
                <td>{{ $customer->company_name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->responsible_person }}</td>
                <td>{{ $customer->position }}</td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}">
                        Redaktə Et
                    </button>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sil</button>
                    </form>
                </td>
            </tr>
            <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerModalLabel{{ $customer->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCustomerModalLabel{{ $customer->id }}">Müştərini Redaktə Et</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="company_name{{ $customer->id }}" class="form-label">Şirkət Adı</label>
                                    <input type="text" name="company_name" id="company_name{{ $customer->id }}" class="form-control" value="{{ $customer->company_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone{{ $customer->id }}" class="form-label">Telefon</label>
                                    <input type="text" name="phone" id="phone{{ $customer->id }}" class="form-control" value="{{ $customer->phone }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email{{ $customer->id }}" class="form-label">Email</label>
                                    <input type="email" name="email" id="email{{ $customer->id }}" class="form-control" value="{{ $customer->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="responsible_person{{ $customer->id }}" class="form-label">Cavabdeh Şəxs</label>
                                    <input type="text" name="responsible_person" id="responsible_person{{ $customer->id }}" class="form-control" value="{{ $customer->responsible_person }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="position{{ $customer->id }}" class="form-label">Vəzifə</label>
                                    <input type="text" name="position" id="position{{ $customer->id }}" class="form-control" value="{{ $customer->position }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="responsible_phone{{ $customer->id }}" class="form-label">Cavabdeh Şəxsin Telefonu</label>
                                    <input type="text" name="responsible_phone" id="responsible_phone{{ $customer->id }}" class="form-control" value="{{ $customer->responsible_phone }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
                                <button type="submit" class="btn btn-success">Yenilə</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="6" class="text-center">Məlumat tapılmadı.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Yeni Müştəri Əlavə Et</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Şirkət Adı</label>
                        <input type="text" name="company_name" id="company_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="responsible_person" class="form-label">Cavabdeh Şəxs</label>
                        <input type="text" name="responsible_person" id="responsible_person" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Vəzifə</label>
                        <input type="text" name="position" id="position" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="responsible_phone" class="form-label">Cavabdeh Şəxsin Telefonu</label>
                        <input type="text" name="responsible_phone" id="responsible_phone" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
                    <button type="submit" class="btn btn-success">Əlavə Et</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
