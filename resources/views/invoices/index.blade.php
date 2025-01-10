@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hesab-Fakturalar</h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">
        Yeni Faktura Yarat
    </a>
    <form method="GET" action="{{ route('invoices.index') }}" class="row mb-4">
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gözləyən</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Ödənilən</option>
                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Gecikmiş</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="customer_id" class="form-select">
                <option value="">Müştəri</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->company_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="service_id" class="form-select">
                <option value="">Xidmət</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="invoice_date" class="form-control" value="{{ request('invoice_date') }}">
        </div>
        <div class="col-md-2">
            <select name="payment_type" class="form-select">
                <option value="">Ödəniş Növü</option>
                <option value="cash" {{ request('payment_type') == 'cash' ? 'selected' : '' }}>Nağd</option>
                <option value="credit_card" {{ request('payment_type') == 'credit_card' ? 'selected' : '' }}>Kredit Kartı</option>
                <option value="bank_transfer" {{ request('payment_type') == 'bank_transfer' ? 'selected' : '' }}>Bank Köçürməsi</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Axtar</button>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Müştəri</th>
                <th>Xidmət</th>
                <th>Xidmət Məbləği</th>
                <th>Status</th>
                <th>Faktura Tarixi</th>
                <th>Ümumi Məbləğ</th>
                <th>Əməliyyatlar</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAmount = 0; @endphp
            @foreach($invoices as $invoice)
            @php $totalAmount += $invoice->due_amount; @endphp
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->customer->company_name }}</td>
                <td>{{ $invoice->service->name }}</td>
                <td>{{ number_format($invoice->amount, 2) }} AZN</td>
                <td>{{ ucfirst($invoice->status) }}</td>
                <td>{{ $invoice->invoice_date }}</td>
                <td>{{ number_format($invoice->due_amount, 2) }} AZN</td>
                <td>
                    @if($invoice->status == 'pending')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#payInvoiceModal{{ $invoice->id }}">
                        Fakturanı Bağla
                    </button>
                    @endif
                </td>
            </tr>
            <div class="modal fade" id="payInvoiceModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="payInvoiceModalLabel{{ $invoice->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="payInvoiceModalLabel{{ $invoice->id }}">Fakturanı Bağla</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="payment_type{{ $invoice->id }}" class="form-label">Ödəniş Növü</label>
                                    <select name="payment_type" id="payment_type{{ $invoice->id }}" class="form-select" required>
                                        <option value="cash">Nağd</option>
                                        <option value="credit_card">Kredit Kartı</option>
                                        <option value="bank_transfer">Bank Köçürməsi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="payment_date{{ $invoice->id }}" class="form-label">Ödəniş Tarixi</label>
                                    <input type="date" name="payment_date" id="payment_date{{ $invoice->id }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
                                <button type="submit" class="btn btn-success">Təsdiqlə</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
