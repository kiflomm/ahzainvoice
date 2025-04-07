<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Invoice Management Routes
Route::middleware(['auth', 'verified.employee'])->group(function () {
    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/export/csv', [InvoiceController::class, 'exportCsv'])->name('invoices.export.csv');

    // Clients
    Route::resource('clients', ClientController::class);
});

// Super Admin Routes
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/verify-employee/{user}', [SuperAdminController::class, 'verifyEmployee'])->name('verify');
    Route::post('/reject-employee/{user}', [SuperAdminController::class, 'rejectEmployee'])->name('reject');
    Route::delete('/remove-employee/{user}', [SuperAdminController::class, 'removeEmployee'])->name('remove');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
