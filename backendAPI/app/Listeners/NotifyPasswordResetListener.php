<?php

namespace App\Listeners;

use App\Mail\NotifyPasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyPasswordResetListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(object $event)
    {
        $user = $event->user;
        $this->sendPasswordResetMail($user->email);

    }

    public function sendPasswordResetMail($userEmail)
    {

        Mail::to($userEmail)->queue(new NotifyPasswordReset($userEmail));
        //\Log::info($userEmail);
    }
}
