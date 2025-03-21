<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookingController;

Route::apiResource('bookings', BookingController::class);