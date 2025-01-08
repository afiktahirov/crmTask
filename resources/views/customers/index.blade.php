@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Müştərilər</h1>
    <!-- Yeni Müştəri Əlavə Et Buttonu -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
        Yeni Müştəri Əlavə Et
    </button>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Müştəri Siyahısı -->
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
            @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->company_name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->responsible_person }}</td>
                <td>{{ $customer->position }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Redaktə Et</a>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sil</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Pəncərə -->
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
