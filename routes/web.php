<?php

use App\Http\Controllers\CashOutController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\SparepartsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'HomeController']);
Route::get('users', [HomeController::class, 'users']);

// Invoices
Route::resource('invoice', InvoicesController::class);
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
