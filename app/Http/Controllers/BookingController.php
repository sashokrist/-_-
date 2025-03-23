<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Business;
use App\Models\BusinessType;
use App\Services\Contracts\BookingServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingServiceInterface $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $bookings = $this->bookingService->getAllWithFilters($request);
        $businessTypes = BusinessType::all();
        $businesses = Business::all();

        return view('bookings.index', compact('bookings', 'businessTypes', 'businesses'));
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
        try {
            $booking = $this->bookingService->createBooking($request);
            return redirect()->route('bookings.index')->with('success', "Успешно запазихте час!  Клиентът ще бъде уведомен с {$booking->notification_method}");
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Грешка при създаване на резервацията.');
        }
    }

    public function edit(Booking $booking)
    {
        try {
            $business = $booking->business->load('businessType');

            if (!$business || !$business->businessType) {
                return redirect()->back()->with('error', 'Не може да се определи бизнес тип за резервацията.');
            }

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
            $updatedBooking = $this->bookingService->updateBooking($booking, $request);

            return redirect()
                ->route('bookings.index')
                ->with('success', "Часът беше редактиран успешно! Клиентът ще бъде уведомен с {$updatedBooking->notification_method}");
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Грешка при актуализиране на резервацията.');
        }
    }

    public function show(Booking $booking)
    {
        $booking = $this->bookingService->showBooking($booking);

        $upcomingBookings = Booking::getUpcomingBookings($booking->personal_id, $booking->id);

        return view('bookings.show', compact('booking', 'upcomingBookings'));
    }

    public function destroy(Booking $booking)
    {
        $this->bookingService->destroyBooking($booking);
        return redirect()->route('bookings.index')->with('success', 'Часът беше изтрит успешно.');
    }
}
