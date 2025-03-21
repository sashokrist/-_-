<?php
use App\Http\Controllers\BookingController;

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

// Other routes for store, show, etc.

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
