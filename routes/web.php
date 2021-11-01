<?php

use App\Http\Controllers\CashOutController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\SparepartsController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PagesController::class, 'home']);
Route::get('/administration', [PagesController::class, 'administration']);

// Invoices route
Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices.index');
Route::get('/create-new-invoice', [InvoicesController::class, 'create']);
Route::post('/invoices', [InvoicesController::class, 'store']);
Route::get('/invoice/{id}/edit', [InvoicesController::class, 'edit']);
Route::put('/invoice/{id}', [InvoicesController::class, 'update']);
Route::delete('/invoice/{id}/delete', [InvoicesController::class, 'destroy']);

// Partners route
Route::get('/partners', [PartnersController::class, 'index'])->name('partners.index');
Route::get('/create-partner', [PartnersController::class, 'create']);
Route::post('/partners', [PartnersController::class, 'store']);
Route::get('/partner/{id}/edit', [PartnersController::class, 'edit']);
Route::put('/partner/{id}', [PartnersController::class, 'update']);
Route::delete('/partner/{id}/delete', [PartnersController::class, 'destroy']);

// Employees route
Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
Route::get('/create-employee', [EmployeesController::class, 'create']);
Route::post('/employees', [EmployeesController::class, 'store']);
Route::get('/employee/{id}/edit', [EmployeesController::class, 'edit']);
Route::put('/employee/{id}', [EmployeesController::class, 'update']);
Route::delete('/employee/{id}/delete', [EmployeesController::class, 'destroy']);

// Sparepart Route
Route::get('/sparepart', [SparepartsController::class, 'index'])->name('spareparts.index');
Route::post('/sparepart', [SparepartsController::class, 'store']);
Route::get('/sparepart/{id}/edit', [SparepartsController::class, 'edit']);
Route::put('/sparepart/{id}', [SparepartsController::class, 'update']);
Route::delete('/sparepart/{id}/delete', [SparepartsController::class, 'destroy']);

// Equipment Route
Route::get('/equipment', [EquipmentsController::class, 'index'])->name('equipments.index');
Route::post('/equipment', [EquipmentsController::class, 'store']);
Route::get('/equipment/{id}/edit', [EquipmentsController::class, 'edit']);
Route::put('/equipment/{id}', [EquipmentsController::class, 'update']);
Route::delete('/equipment/{id}/delete', [EquipmentsController::class, 'destroy']);

// Cash In Route
Route::get('/cash-out', [CashOutController::class, 'index'])->name('cash-out.index');
Route::post('/cash-out', [CashOutController::class, 'store']);
Route::get('/cash-out/{id}/edit', [CashOutController::class, 'edit']);
Route::put('/cash-out/{id}', [CashOutController::class, 'update']);
Route::delete('/cash-out/{id}/delete', [CashOutController::class, 'destroy']);
