<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/reports');
});

Route::resource('customers', CustomerController::class);
Route::resource('services', ServiceController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('expenses', ExpenseController::class);

Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
