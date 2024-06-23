<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

trait GlobalData
{
    function generateOtp(): int
    {
        return mt_rand(100000, 999999);
    }

    function sendOtpViaSms(User $recipient, $otp)
    {
        $account_sid = getenv('TWILIO_ACCOUNT_SID');
        $auth_token = getenv('TWILIO_AUTH_TOKEN');
        $twilio_number = getenv('TWILIO_NUMBER');
        try {
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                '+263' . Str::substr($recipient->phoneNumber, '1'),
                array(
                    'from' => $twilio_number,
                    'body' => 'Dear ' . $recipient->firstName . '. Here is your otp for system access ' . $otp
                )
            );

        } catch (ConfigurationException|TwilioException $e) {
            Log::info("Error sending OTP ", [$e->getMessage()]);
        }
    }
}
