<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Service;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->has('customer_id') && $request->customer_id != '') {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->has('service_id') && $request->service_id != '') {
            $query->where('service_id', $request->service_id);
        }
        if ($request->has('invoice_date') && $request->invoice_date != '') {
            $query->whereDate('invoice_date', $request->invoice_date);
        }
        if ($request->has('payment_type') && $request->payment_type != '') {
            $query->where('payment_type', $request->payment_type);
        }
        if ($request->has('payment_date') && $request->payment_date != '') {
            $query->whereDate('payment_date', $request->payment_date);
        }

        $invoices = $query->with(['customer', 'service'])->get();
        $customers = Customer::all();
        $services = Service::all();

        return view('invoices.index', compact('invoices', 'customers', 'services'));
    }


    public function create()
    {
        $customers = Customer::all();
        $services = Service::all();
        return view('invoices.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'amount' => 'required|numeric|min:0',
            'invoice_date' => 'required|date',
        ]);
    
        $service = \App\Models\Service::find($validated['service_id']);
        $price = $service->price;
        $interval = $service->interval;
    
        $now = now();
        $invoiceDate = \Carbon\Carbon::parse($validated['invoice_date']);
        $diff = $invoiceDate->diffInDays($now);
    
        $dueAmount = match ($interval) {
            'daily' => $price * $diff,
            'weekly' => $price * ceil($diff / 7),
            'monthly' => $price * ceil($diff / 30),
            'yearly' => $price * ceil($diff / 365),
            default => $price,
        };
    
        $invoice = \App\Models\Invoice::create([
            'customer_id' => $validated['customer_id'],
            'service_id' => $validated['service_id'],
            'amount' => $price,
            'due_amount' => $dueAmount,
            'invoice_date' => $validated['invoice_date'],
            'status' => 'pending',
        ]);
    
        return redirect()->route('invoices.index')->with('success', 'Faktura uğurla yaradıldı!');
    }
    


    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'payment_type' => 'required|in:cash,credit_card,bank_transfer',
            'payment_date' => 'required|date',
        ]);

        $invoice->update([
            'payment_type' => $validated['payment_type'],
            'payment_date' => $validated['payment_date'],
            'status' => 'paid',
        ]);

        return redirect()->route('invoices.index')->with('success', 'Faktura ödənildi!');
    }
}
