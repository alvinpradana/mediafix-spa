<?php

use App\Http\Controllers\CashOutController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\SparepartsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group( function () {
    // Login
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login');
});

Route::middleware('auth')->group( function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::resource('users', UsersController::class);
    Route::put('users', [UsersController::class, 'password'])->name('password.update');

    // Auth
    Route::get('profile', [UsersController::class, 'profile'])->name('user.profile');

    // Logout
    Route::delete('logout', LogoutController::class)->name('logout');

    // Invoices
    Route::resource('invoice', InvoicesController::class);

    Route::put('invoice-taken/{id}', [InvoicesController::class, 'mark'])->name('invoice.taken');
    Route::get('invoice-print/{id}', [InvoicesController::class, 'print'])->name('invoice.print');
    Route::get('invoices-export', [InvoicesController::class, 'export'])->name('invoices.export');

    // Partners
    Route::resource('partners', PartnersController::class);
    Route::get('partners-export', [PartnersController::class, 'export'])->name('partners.export');

    // Employees
    Route::resource('employees', EmployeesController::class);

    Route::get('employees-export', [EmployeesController::class, 'export'])->name('employee.export');

    // Sparepart
    Route::resource('sparepart', SparepartsController::class);

    Route::post('sparepart-import', [SparepartsController::class, 'import'])->name('sparepart.import');
    Route::get('sparepart-export', [SparepartsController::class, 'export'])->name('sparepart.export');

    // Equipment
    Route::resource('equipment', EquipmentsController::class);

    Route::post('equipment-import', [EquipmentsController::class, 'import'])->name('equipment.import');
    Route::get('equipment-export', [EquipmentsController::class, 'export'])->name('equipment.export');

    // Cash
    Route::resource('cash', CashOutController::class);

    Route::post('cash-out-import', [CashOutController::class, 'import'])->name('cash.import');
    Route::get('cash-out-export', [CashOutController::class, 'export'])->name('cash.export');
});