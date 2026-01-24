<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Ping (debug)
|--------------------------------------------------------------------------
*/
Route::get('/_ping', function () {
    return 'PING OK - my_wallet_app';
});

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/topups-test', function () {
        return 'TOPUPS TEST OK';
    });

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Topups
    Route::get('/topups', [TopupController::class, 'index'])->name('topups.index');
    Route::get('/topups/create', [TopupController::class, 'create'])->name('topups.create');
    Route::post('/topups', [TopupController::class, 'store'])->name('topups.store');

    // Expenses (create + store + history)
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
});

require __DIR__ . '/auth.php';
