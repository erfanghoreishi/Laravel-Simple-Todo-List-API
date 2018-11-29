<?php

namespace App\Listeners;

use App\Notifications\UserRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendSMSVerificationNotification implements ShouldQueue
{

    /**
     * Handle the event.
     *send sms notification to user using nexmo sms api
     * @param  object $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if (env('NEXMO')) {

            $user = $event->user;
            Notification::send($user, new UserRegisteredNotification($user));
        }


    }
}
