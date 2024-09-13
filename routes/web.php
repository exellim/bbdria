<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StartTreatmentController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\TreatmentsController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Customers Start
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/{id}/gallery', [CustomerController::class, 'galleries'])->name('customer.galleries');
    Route::post('/customer/{id}/gls', [CustomerController::class, 'galleriesstore'])->name('customer.galleriesstore');
    Route::get('/customer/cr', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer/st', [CustomerController::class, 'store'])->name('customer.store');
    // Customers End

    // Categories Start
    Route::get('/categories',[CategoryController::class, 'index'])->name('category.index');
    Route::post('/categories/cr', [CategoryController::class, 'store'])->name('category.store');
    // Categories End

    // Items Start
    Route::get('/items',[ItemsController::class, 'index'])->name('items.index');
    Route::post('/items/cr',[ItemsController::class, 'store'])->name('items.store');
    // Items End

    // Supplies Start
    Route::get('/supplies',[SuppliesController::class, 'index'])->name('supplies.index');
    Route::post('/supplies/cr',[SuppliesController::class, 'store'])->name('supplies.store');
    Route::put('/supplies/{id}/up',[SuppliesController::class, 'update'])->name('supplies.update');
    Route::get('/supply/in',[SuppliesController::class, 'in'])->name('supply.in');
    Route::get('/supply/out',[SuppliesController::class, 'out'])->name('supply.out');
    // Supplies End

    // Treatments Start
    Route::get('/treatments',[TreatmentsController::class, 'index'])->name('treatments.index');
    Route::post('/treatments/cr',[TreatmentsController::class, 'store'])->name('treatments.store');
    // Treatments End

    // Appointments + Treatments Start
    Route::get('/appointments',[AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments/cr',[AppointmentController::class, 'store'])->name('appointments.store');
    Route::put('/appointments/{id}/uptime',[AppointmentController::class, 'updateTime'])->name('appointments.update.time');
    Route::get('/appointments/{receipt}',[AppointmentController::class, 'changeTr'])->name('appointments.changetr');
    Route::put('/appointments/{receipt}/uptr',[AppointmentController::class, 'acceptTr'])->name('appointments.update.tr');


    Route::get('/attend/appointments/{id}',[StartTreatmentController::class, 'index'])->name('appointments.attend');
    Route::post('/attend/appointments/{receipt_code}',[StartTreatmentController::class, 'store'])->name('appointments.finish');
    // Appointments + Treatments End

    // Ajax Start
    Route::get('/treatment-price', [AjaxController::class, 'getTreatmentPrice'])->name('treatment.price');
    // Ajax End
});

require __DIR__.'/auth.php';

