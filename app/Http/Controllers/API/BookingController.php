<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Business};
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        try {
            $bookings = Booking::with(['business.businessType', 'doctor', 'hairstylist', 'table'])
                ->filter($request->all())
                ->orderBy('id', 'DESC')
                ->paginate(10);

            return response()->json($bookings);
        } catch (Exception $e) {
            Log::error('Error fetching bookings: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching bookings.'], 500);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'business_id' => 'required|exists:businesses,id',
            'date_time' => 'required|date|after:now',
            'client_name' => 'required|string|max:255',
            'personal_id' => 'required|string|size:10',
            'notification_method' => 'required|in:SMS,Email',
            'provider_type' => 'required|string|in:doctor,hair_salon,restaurant',
            'service_provider_id' => 'required|integer',
        ];

        $validated = $request->validate($rules);

        try {
            $booking = Booking::createBooking($request);

            $business = $booking->business;
            if ($business) {
                NotificationService::sendNotification(
                    $booking->notification_method,
                    $business->phone,
                    $business->email,
                    $booking
                );
            }

            return response()->json([
                'message' => 'Booking created successfully.',
                'data' => $booking
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return response()->json(['error' => 'Error creating booking.'], 500);
        }
    }

    public function show(Booking $booking)
    {
        try {
            $booking->load(['business.businessType', 'doctor', 'hairstylist', 'table']);
            return response()->json($booking);
        } catch (Exception $e) {
            Log::error('Error fetching booking: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching booking.'], 500);
        }
    }

    public function update(Request $request, Booking $booking)
    {
        $rules = [
            'business_id' => 'required|exists:businesses,id',
            'date_time' => 'required|date|after:now',
            'client_name' => 'required|string|max:255',
            'personal_id' => 'required|string|size:10',
            'notification_method' => 'required|in:SMS,Email',
            'provider_type' => 'required|string|in:doctor,hair_salon,restaurant',
            'service_provider_id' => 'required|integer',
        ];

        $validated = $request->validate($rules);

        try {
            // Map provider dynamically
            switch ($validated['provider_type']) {
                case 'doctor':
                    $validated['doctor_id'] = $validated['service_provider_id'];
                    $validated['hairstylist_id'] = null;
                    $validated['table_id'] = null;
                    break;
                case 'hair_salon':
                    $validated['hairstylist_id'] = $validated['service_provider_id'];
                    $validated['doctor_id'] = null;
                    $validated['table_id'] = null;
                    break;
                case 'restaurant':
                    $validated['table_id'] = $validated['service_provider_id'];
                    $validated['doctor_id'] = null;
                    $validated['hairstylist_id'] = null;
                    break;
            }

            unset($validated['provider_type'], $validated['service_provider_id']);

            $booking->updateBooking($validated);

            return response()->json([
                'message' => 'Booking updated successfully.',
                'data' => $booking
            ]);
        } catch (Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return response()->json(['error' => 'Error updating booking.'], 500);
        }
    }

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
