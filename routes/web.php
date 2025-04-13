<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    $recordController = new RecordController();
    $recentRecords = $recordController->getRecentRecords();
    $stats = $recordController->getDashboardStats();

    return Inertia::render('Dashboard', [
        'stats' => [
            'totalRecords' => $stats['totalRecords'],
            'totalAmount' => '$' . $stats['totalAmount'],
            'pendingRecords' => $stats['pendingRecords'],
            'pendingAmount' => '$' . $stats['pendingAmount'],
            'overdueRecords' => $stats['overdueRecords'],
            'overdueAmount' => '$' . $stats['overdueAmount'],
        ],
        'recentRecords' => $recentRecords,
        'summary' => [
            'paidRecords' => $stats['paidRecords'],
            'pendingRecords' => $stats['pendingRecords'],
            'overdueRecords' => $stats['overdueRecords'],
            'outstandingAmount' => '$' . $stats['outstandingAmount'],
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Employee Routes - Record Management
Route::middleware(['auth', \App\Http\Middleware\VerifiedEmployee::class])->group(function () {
    Route::resource('records', RecordController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('bills', BillController::class);
    Route::resource('clients', ClientController::class);
});

// Admin Routes - User Management
Route::middleware(['auth', \App\Http\Middleware\VerifiedAdmin::class])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');
    Route::post('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
    Route::delete('/users/{user}', [UserController::class, 'remove'])->name('users.remove');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';