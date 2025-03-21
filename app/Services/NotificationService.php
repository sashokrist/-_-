<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use App\Services\SmsService;  // Include SmsService

class NotificationService
{
    /**
     * Send notification (SMS or Email) based on the booking's notification method.
     *
     * @param string $notificationMethod
     * @param string $phoneNumber
     * @param string $email
     * @param object $booking
     * @return void
     */
    public static function sendNotification($notificationMethod, $phoneNumber, $email, $booking)
    {
        $message = "Вашият час е редактиран за {$booking->date_time}. Клиентът ще бъде информиран с {$notificationMethod}.";

        if ($notificationMethod === 'Email') {
            self::sendEmail($email, $booking);
        } elseif ($notificationMethod === 'SMS') {
            self::sendSms($phoneNumber, $message);
        }
    }

    /**
     * Send email notification.
     *
     * @param string $email
     * @param object $booking
     * @return void
     */
    private static function sendEmail($email, $booking)
    {
        Mail::to($email)->send(new BookingConfirmationMail($booking));
    }

    /**
     * Send SMS notification.
     *
     * @param string $phoneNumber
     * @param string $message
     * @return void
     */
    private static function sendSms($phoneNumber, $message)
    {
        SmsService::sendSms($phoneNumber, $message);
    }
}
