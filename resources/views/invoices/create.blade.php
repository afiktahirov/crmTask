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
                <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-interval="{{ $service->interval }}">
                    {{ $service->name }}
                </option>
                @endforeach            
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Məbləğ</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" value="0.00" required readonly>
        </div>
        <div class="mb-3">
            <label for="invoice_date" class="form-label">Faktura Tarixi</label>
            <input type="date" name="invoice_date" id="invoice_date" class="form-control" required max="{{ now()->toDateString() }}">
        </div>
        <button type="submit" class="btn btn-primary">Yarat</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_id');
        const amountInput = document.getElementById('amount');
        const invoiceDateInput = document.getElementById('invoice_date');
        const dueAmountInput = document.createElement('input'); 
        dueAmountInput.setAttribute('type', 'text');
        dueAmountInput.setAttribute('readonly', true);
        dueAmountInput.setAttribute('id', 'due_amount');
        dueAmountInput.classList.add('form-control', 'mt-3');
        amountInput.parentNode.appendChild(dueAmountInput);

        const today = new Date().toISOString().split('T')[0];
        invoiceDateInput.setAttribute('max', today);

        serviceSelect.addEventListener('change', calculateDueAmount);
        invoiceDateInput.addEventListener('change', calculateDueAmount);

        function calculateDueAmount() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const interval = selectedOption.getAttribute('data-interval') || 'daily';
            const invoiceDate = new Date(invoiceDateInput.value);
            const today = new Date();

            if (isNaN(invoiceDate.getTime()) || price === 0) {
                dueAmountInput.value = "0.00";
                return;
            }

            const diffTime = Math.abs(today - invoiceDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            let dueAmount = 0;
            switch (interval) {
                case 'daily':
                    dueAmount = price * diffDays;
                    break;
                case 'weekly':
                    dueAmount = price * Math.ceil(diffDays / 7);
                    break;
                case 'monthly':
                    dueAmount = price * Math.ceil(diffDays / 30);
                    break;
                case 'yearly':
                    dueAmount = price * Math.ceil(diffDays / 365);
                    break;
                default:
                    dueAmount = price;
            }

            dueAmountInput.value = dueAmount.toFixed(2);
        }
    });
</script>
@endsection
