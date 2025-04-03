<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Invoice Management Routes
Route::middleware('auth')->group(function () {
    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/export/csv', [InvoiceController::class, 'exportCsv'])->name('invoices.export.csv');

    // Vendors
    Route::resource('vendors', VendorController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
