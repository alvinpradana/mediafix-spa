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
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

// Invoice
Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('invoice', [WebController::class, 'invoice'])->name('invoice');

Route::middleware('guest')->group( function () {
    // Login
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login');
});

Route::middleware('auth')->group( function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::resource('dashboard/users', UsersController::class);
    Route::put('dashboard/users', [UsersController::class, 'password'])->name('password.update');

    // User Image
    Route::post('user/image', [UsersController::class, 'storeImage'])->name('user.image');

    // Auth
    Route::get('dashboard/profile', [UsersController::class, 'profile'])->name('user.profile');

    // Logout
    Route::delete('logout', LogoutController::class)->name('logout');

    // Invoices
    Route::resource('dashboard/invoice', InvoicesController::class);

    Route::put('dashboard/invoice-taken/{id}', [InvoicesController::class, 'mark'])->name('invoice.taken');
    Route::get('dashboard/invoice-print/{id}', [InvoicesController::class, 'print'])->name('invoice.print');
    Route::get('dashboard/invoices-export', [InvoicesController::class, 'export'])->name('invoices.export');

    // Partners
    Route::resource('partners', PartnersController::class);
    Route::get('partners/partners-export', [PartnersController::class, 'export'])->name('partners.export');

    // Employees
    Route::resource('employees', EmployeesController::class);

    Route::get('employees/employees-export', [EmployeesController::class, 'export'])->name('employee.export');

    // Sparepart
    Route::resource('sparepart', SparepartsController::class);

    Route::post('sparepart/sparepart-import', [SparepartsController::class, 'import'])->name('sparepart.import');
    Route::get('sparepart/sparepart-export', [SparepartsController::class, 'export'])->name('sparepart.export');

    // Equipment
    Route::resource('equipment', EquipmentsController::class);

    Route::post('equipment/equipment-import', [EquipmentsController::class, 'import'])->name('equipment.import');
    Route::get('equipment/equipment-export', [EquipmentsController::class, 'export'])->name('equipment.export');

    // Cash
    Route::resource('dashboard/cash', CashOutController::class);

    Route::post('dashboard/cash-out-import', [CashOutController::class, 'import'])->name('cash.import');
    Route::get('dashboard/cash-out-export', [CashOutController::class, 'export'])->name('cash.export');
});