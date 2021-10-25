<?php

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PartnersController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PagesController::class, 'home']);
Route::get('/reports', [PagesController::class, 'reports']);

// Invoices route
Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices.index');
Route::get('/create-new-invoice', [InvoicesController::class, 'create']);
Route::post('/invoices', [InvoicesController::class, 'store']);
Route::get('/invoice/{id}/edit', [InvoicesController::class, 'edit']);
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