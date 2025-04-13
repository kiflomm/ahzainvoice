<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    $recordController = new RecordController();
    $recentRecords = $recordController->getRecentRecords();
    
    // Mock stats for now - you can implement real stats calculation later
    $stats = [
        'totalRecords' => 53,
        'totalAmount' => '$15,240.65',
        'pendingRecords' => 12,
        'pendingAmount' => '$4,320.00',
        'overdueRecords' => 3,
        'overdueAmount' => '$1,120.50'
    ];

    return Inertia::render('Dashboard', [
        'stats' => $stats,
        'recentRecords' => $recentRecords,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('records', RecordController::class);
// Invoices - Specific routes for invoice management
Route::resource('invoices', InvoiceController::class);

 // Bills - Specific routes for bill management
 Route::resource('bills', BillController::class);

 // Clients
 Route::resource('clients', ClientController::class);

// User Management Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// Super Admin Routes
// Record Management Routes
Route::middleware(['auth', 'verified.employee'])->group(function () {
    // Generic Records

});
Route::middleware(['auth'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/verify-employee/{user}', [SuperAdminController::class, 'verifyEmployee'])->name('verify');
    Route::post('/reject-employee/{user}', [SuperAdminController::class, 'rejectEmployee'])->name('reject');
    Route::delete('/remove-employee/{user}', [SuperAdminController::class, 'removeEmployee'])->name('remove');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';