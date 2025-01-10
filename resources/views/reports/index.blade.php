@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hesabatlıq</h1>

    <form method="GET" action="{{ route('reports.index') }}" class="row mb-4">
        <div class="col-md-3">
            <label for="customer_id" class="form-label">Müştəri</label>
            <select name="customer_id" id="customer_id" class="form-select">
                <option value="">Müştəri seçin</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->company_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="service_id" class="form-label">Xidmət</label>
            <select name="service_id" id="service_id" class="form-select">
                <option value="">Xidmət seçin</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="date_from" class="form-label">Başlanğıc Tarixi</label>
            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <label for="date_to" class="form-label">Son Tarix</label>
            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100" style="margin-top: 30px;">Axtar</button>
        </div>
    </form>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Ümumi Dövriyyə</div>
                <div class="card-body">
                    <h3>{{ number_format($revenue, 2) }} AZN</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-white">Ümumi Xərclər</div>
                <div class="card-body">
                    <h3>{{ number_format($totalExpenses, 2) }} AZN</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">Gəlir</div>
                <div class="card-body">
                    <h3>{{ number_format($profit, 2) }} AZN</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
