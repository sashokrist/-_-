<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Models\Booking;

interface BookingServiceInterface
{
    public function getAllWithFilters(Request $request);
    public function createBooking(Request $request): Booking;
    public function updateBooking(Booking $booking, Request $request): Booking;
    public function showBooking(Booking $booking);
    public function destroyBooking(Booking $booking): bool;
}
