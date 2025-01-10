@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Hesab-Faktura Yarat</h1>
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="customer_id" class="form-label">Müştəri</label>
            <select name="customer_id" id="customer_id" class="form-select" required>
                <option value="">Müştəri seçin</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="service_id" class="form-label">Xidmət</label>
            <select name="service_id" id="service_id" class="form-select" required>
                <option value="">Xidmət seçin</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Məbləğ</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" value="0.00" required readonly>
        </div>
        <div class="mb-3">
            <label for="invoice_date" class="form-label">Faktura Tarixi</label>
            <input type="date" name="invoice_date" id="invoice_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Yarat</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_id');
        const amountInput = document.getElementById('amount');

        serviceSelect.addEventListener('change', function() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            amountInput.value = parseFloat(price).toFixed(2);
        });
    });
</script>
@endsection
