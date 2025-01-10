<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('customers', CustomerController::class);
Route::resource('services', ServiceController::class);
Route::resource('invoices', InvoiceController::class);
