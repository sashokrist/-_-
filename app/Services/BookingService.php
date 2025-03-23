<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Services\Contracts\BookingServiceInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookingService implements BookingServiceInterface
{
    public function getAllWithFilters(Request $request)
    {
        return Booking::with(['business.businessType', 'doctor', 'hairstylist', 'table'])
            ->filter($request->all())
            ->orderBy('id', 'DESC')
            ->paginate(10)
            ->appends($request->all());
    }

    public function createBooking(Request $request): Booking
    {
        $validator = Validator::make($request->all(), [
            'business_id' => 'required|exists:businesses,id',
            'date_time' => 'required|date|after:now',
            'client_name' => 'required|string|max:255',
            'personal_id' => 'required|string|size:10',
            'notification_method' => 'required|in:SMS,Email',
            'provider_type' => 'required|string|in:doctor,hair_salon,restaurant',
            'service_provider_id' => 'required|integer',
        ], [
            'personal_id.size' => 'ЕГН трябва да съдържа точно 10 символа.',
            'date_time.after' => 'Моля, изберете бъдеща дата и час.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

//        $business = $booking->business;
//
//        if ($business) {
//            NotificationService::sendNotification(
//                $booking->notification_method,
//                $business->phone,
//                $business->email,
//                $booking
//            );
//        }

        return Booking::createBooking($request);
    }


    public function updateBooking(Booking $booking, Request $request): Booking
    {
        $validator = Validator::make($request->all(), [
            'business_id' => 'required|exists:businesses,id',
            'date_time' => 'required|date|after:now',
            'client_name' => 'required|string|max:255',
            'personal_id' => 'required|string|size:10',
            'notification_method' => 'required|in:SMS,Email',
            'provider_type' => 'required|string|in:doctor,hair_salon,restaurant',
            'service_provider_id' => 'required|integer',
        ], [
            'personal_id.size' => 'ЕГН трябва да съдържа точно 10 символа.',
            'date_time.after' => 'Моля, изберете бъдеща дата и час.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Map dynamic provider
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

        //        $business = $booking->business;
//
//        if ($business) {
//            NotificationService::sendNotification(
//                $booking->notification_method,
//                $business->phone,
//                $business->email,
//                $booking
//            );
//        }
        return $booking;
    }

    public function showBooking(Booking $booking)
    {
        return $booking->load(['business.businessType', 'doctor', 'hairstylist', 'table']);
    }

    public function destroyBooking(Booking $booking): bool
    {
        return $booking->delete();
    }
}
