<?php

namespace App\Http\Controllers\api\Auth;

use App\Notifications\UserRegisteredNotification;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SMSVerificationController extends Controller
{


    /**
     * Mark the authenticated user's phone number as verified.
     *
     */
    public function verify($code)
    {

        $user = auth()->user();
        $result = 'wrong verification code';

        if ($code == $user->sms_code) {
            //TODO new SMSVerified event should be sent
            $result = $user->forceFill([
                'phone_verified_at' => $user->freshTimestamp(),
            ])->save();

        }

        return response()->json(["data" => array('message' => $result)]);


    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function resend(Request $request)
    {

        $user = auth()->user();
        $user->sms_code = rand(0, 99999);
        $user->save();
        $nexmo = env('NEXMO');

        if ($nexmo) {
            Notification::send($user, new UserRegisteredNotification($user));
        }
        $result = $nexmo ? "notification is send" : "set  NEXMO in env file";

        return response()->json(["data" => array('message' => $result)]);

    }
}
