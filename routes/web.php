<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;

Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

Route::post('/customers/{customer}/payment', [CustomerController::class, 'updatePayment'])->name('customers.updatePayment');
Route::get('/customers/{id}/payments', [CustomerController::class, 'Payment_history'])->name('customers.payments');

Route::get('/customers/no-due', [CustomerController::class, 'noDueCustomers'])->name('customers.no_due');