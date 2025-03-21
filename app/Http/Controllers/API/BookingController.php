<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $bookings = Booking::with('doctor')->orderBy('id', 'DESC')->paginate(10);
            return response()->json($bookings);
        } catch (Exception $e) {
            Log::error('Error fetching bookings: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching bookings.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            $booking = Booking::createBooking($request);

            return response()->json([
                'message' => 'Booking created successfully!',
                'data' => $booking
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return response()->json(['error' => 'Error creating booking.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Booking $booking)
    {
        try {
            return response()->json($booking);
        } catch (Exception $e) {
            Log::error('Error fetching booking details: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching booking details.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBookingRequest $request
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        try {
            $booking->updateBooking($request->validated());

            return response()->json([
                'message' => 'Booking updated successfully!',
                'data' => $booking
            ]);
        } catch (Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return response()->json(['error' => 'Error updating booking.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return response()->json(['message' => 'Booking deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return response()->json(['error' => 'Error deleting booking.'], 500);
        }
    }
}
