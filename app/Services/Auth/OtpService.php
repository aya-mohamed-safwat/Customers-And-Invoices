<?php
namespace App\Services\Auth;

use App\Models\Otp;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Notification;


class OtpService{

    public function generateSendOtp(String $email): Otp{
        $otpCode = rand(100000, 999999);

        $otp=Otp::create([
            'email' => $email,
            'code' => $otpCode,
            'expires_at' => now()->addMinutes(10),
        ]);

        Notification::route('mail', $email) ->notify(new EmailVerificationNotification($otpCode));

        return $otp;
    }



    
    public function validate(string $email, string $code): ?Otp
    {
        return Otp::where('email', $email)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->first();
    }
}