<?php
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HairstylistController;
use App\Http\Controllers\TableController;

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('bookings', BookingController::class);
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/bookings/create/{businessId}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

Route::resource('doctors', DoctorController::class)->except(['create', 'edit']);
Route::resource('hairstylists', HairstylistController::class)->except(['create', 'edit']);
Route::resource('restaurant-tables', TableController::class)->except(['create', 'edit']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
