<?php

namespace App\Services;

class SmsService
{
    public static function sendSms($phoneNumber, $message)
    {
        // Simulate sending an SMS (not actually sending it)
        // Return a message indicating the SMS would have been sent
        return "SMS would have been sent to $phoneNumber with the message: $message";
    }
}
