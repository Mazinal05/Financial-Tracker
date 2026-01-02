<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('expenses', ExpenseController::class)->only(['index', 'store', 'destroy', 'create']);
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    Route::patch('/debts/{debt}/pay', [App\Http\Controllers\DebtController::class, 'markAsPaid'])->name('debts.pay');
    Route::resource('debts', App\Http\Controllers\DebtController::class);
        
    Route::patch('/debts/{debt}/pay', [App\Http\Controllers\DebtController::class, 'markAsPaid'])->name('debts.pay');
    Route::resource('debts', App\Http\Controllers\DebtController::class);

    Route::get('/split-bill', [App\Http\Controllers\SplitBillController::class, 'index'])->name('split-bill.index');
    Route::post('/split-bill', [App\Http\Controllers\SplitBillController::class, 'store'])->name('split-bill.store');
        
    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.users.index');
        Route::patch('/admin/users/{user}/suspend', [App\Http\Controllers\AdminController::class, 'suspend'])->name('admin.users.suspend');
        Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.users.destroy');
    });
});
