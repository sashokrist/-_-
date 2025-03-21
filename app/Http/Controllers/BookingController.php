<?php

namespace App\Http\Controllers;


use App\Models\Booking;
use App\Models\Business;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Services\NotificationService;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info('Filters applied:', $request->all());

            $bookings = Booking::with([
                'business',
                'business.businessType',
                'doctor',
                'hairstylist',
                'table'
            ])
                ->filter($request->all())
                ->orderBy('id', 'DESC')
                ->paginate(10)
                ->appends($request->all());

            $businessTypes = BusinessType::all();
            $businesses = Business::all();

            return view('bookings.index', compact('bookings', 'businessTypes', 'businesses'));

        } catch (Exception $e) {
            Log::error('Error fetching bookings: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Грешка при зареждане на резервациите.');
        }
    }

    public function show(Booking $booking)
    {
        try {
            $booking->load(['business.businessType', 'doctor', 'hairstylist', 'table']);

            // Load upcoming bookings for the same client, excluding current one
            $upcomingBookings = Booking::where('personal_id', $booking->personal_id)
                ->where('id', '!=', $booking->id)
                ->where('date_time', '>', now())
                ->orderBy('date_time')
                ->take(5)
                ->get();

            return view('bookings.show', compact('booking', 'upcomingBookings'));
        } catch (Exception $e) {
            Log::error('Error loading booking details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Грешка при зареждане на детайлите.');
        }
    }


    public function create($businessId)
    {
        $business = Business::with('businessType')->findOrFail($businessId);

        $data = [
            'business' => $business,
            'userName' => auth()->user()->name,
        ];

        switch ($business->businessType->name) {
            case 'Doctor':
                $data['doctors'] = $business->doctors;
                break;
            case 'Hair Salon':
                $data['hairstylists'] = $business->hairstylists;
                break;
            case 'Restaurant':
                $data['tables'] = $business->tables;
                break;
            default:
                return redirect()->back()->with('error', 'Неподдържан тип бизнес.');
        }

        return view('bookings.create', $data);
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

        $messages = [
            'personal_id.size' => 'ЕГН трябва да съдържа точно 10 символа.',
            'date_time.after' => 'Моля, изберете бъдеща дата и час.',
        ];

        $validated = $request->validate($rules, $messages);

        try {
            $booking = Booking::createBooking($request);

            $business = $booking->business;

            if ($business) {
                $phone = $business->phone;
                $email = $business->email;

                NotificationService::sendNotification(
                    $booking->notification_method,
                    $phone,
                    $email,
                    $booking
                );
            }

            return redirect()->route('bookings.index')->with('success', "Успешно запазихте час! Клиентът ще бъде уведомен с {$booking->notification_method}.");
        } catch (Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Грешка при създаване на резервацията.');
        }
    }


    public function edit(Booking $booking)
    {
        try {
            $business = $booking->business->load('businessType');

            if (!$business || !$business->businessType) {
                return redirect()->back()->with('error', 'Не може да се определи бизнес тип за резервацията.');
            }

            // Always define all variables used in the view
            $data = [
                'booking' => $booking,
                'business' => $business,
                'doctors' => [],
                'hairstylists' => [],
                'tables' => [],
            ];

            switch ($business->businessType->name) {
                case 'Doctor':
                    $data['doctors'] = $business->doctors;
                    break;

                case 'Hair Salon':
                    $data['hairstylists'] = $business->hairstylists;
                    break;

                case 'Restaurant':
                    $data['tables'] = $business->tables;
                    break;

                default:
                    return redirect()->back()->with('error', 'Неподдържан тип бизнес.');
            }

            return view('bookings.edit', $data);

        } catch (Exception $e) {
            Log::error('Error loading edit page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Грешка при зареждане на страницата за редактиране.');
        }
    }

    public function update(Request $request, Booking $booking)
    {
        try {
            $validated = $request->validate([
                'business_id' => 'required|exists:businesses,id',
                'date_time' => 'required|date|after:now',
                'client_name' => 'required|string|max:255',
                'personal_id' => 'required|string|size:10',
                'notification_method' => 'required|in:SMS,Email',
                'provider_type' => 'required|string|in:doctor,hair_salon,restaurant',
                'service_provider_id' => 'required|integer',
            ]);

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

            unset($validated['service_provider_id'], $validated['provider_type']);

            $booking->updateBooking($validated);

            return redirect()->route('bookings.index')->with('success', "Часът беше редактиран успешно! Клиентът ще бъде уведомен с {$booking->notification_method}");
        } catch (Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Грешка при актуализиране на резервацията.');
        }
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return redirect()->route('bookings.index')->with('success', 'Часът беше изтрит успешно.');
        } catch (Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Грешка при изтриване на резервацията.');
        }
    }
}
