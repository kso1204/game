<?php

namespace App\Listeners;

use App\Events\UserSubscribed;
use App\Mail\SendEmailMailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailOwnerAboutSubscription
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserSubscribed  $event
     * @return void
     */
    public function handle(UserSubscribed $event)
    {
        //
        Log::info('새로운 사용자에 대한 이메일을 운영자에게 발송:'. $event->user->email);

        Mail::to('kso1204@geni-pco.com')
            ->send(new SendEmailMailable($event->user));
    }
}
