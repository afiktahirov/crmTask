<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Service;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        $query = \App\Models\Invoice::query()->where('status', 'paid');
    
        if ($request->has('customer_id') && $request->customer_id != '') {
            $query->where('customer_id', $request->customer_id);
        }
    
        if ($request->has('service_id') && $request->service_id != '') {
            $query->where('service_id', $request->service_id);
        }
    
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('invoice_date', [$request->date_from, $request->date_to]);
        }
    
        $revenue = $query->sum('due_amount');
    
        $expenses = \App\Models\Expense::query();
    
        if ($request->has('date_from') && $request->has('date_to')) {
            $expenses->whereBetween('expense_date', [$request->date_from, $request->date_to]);
        }
    
        $totalExpenses = $expenses->sum('amount');
    
        $profit = $revenue - $totalExpenses;
    
        $customers = \App\Models\Customer::all(); 
        $services = \App\Models\Service::all(); 
    
        return view('reports.index', compact('revenue', 'totalExpenses', 'profit', 'customers', 'services'));
    }
    
}
