@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ isset($customer) ? 'Müştərini Redaktə Et' : 'Yeni Müştəri Əlavə Et' }}</h1>
    <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST">
        @csrf
        @if(isset($customer))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="company_name">Şirkət Adı</label>
            <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $customer->company_name ?? old('company_name') }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Telefon</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $customer->phone ?? old('phone') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $customer->email ?? old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="responsible_person">Cavabdeh Şəxs</label>
            <input type="text" name="responsible_person" id="responsible_person" class="form-control" value="{{ $customer->responsible_person ?? old('responsible_person') }}" required>
        </div>
        <div class="form-group">
            <label for="position">Vəzifə</label>
            <input type="text" name="position" id="position" class="form-control" value="{{ $customer->position ?? old('position') }}" required>
        </div>
        <div class="form-group">
            <label for="responsible_phone">Cavabdeh Şəxsin Telefonu</label>
            <input type="text" name="responsible_phone" id="responsible_phone" class="form-control" value="{{ $customer->responsible_phone ?? old('responsible_phone') }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">{{ isset($customer) ? 'Yenilə' : 'Əlavə Et' }}</button>
    </form>
</div>
@endsection
