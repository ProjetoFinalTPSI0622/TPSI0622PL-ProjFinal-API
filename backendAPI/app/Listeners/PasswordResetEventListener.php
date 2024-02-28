<?php

namespace App\Listeners;

use App\Mail\PasswordResetMail;
use App\Mail\TicketCreatedMail;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PasswordResetEventListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->sendEmail($event->user);
    }

    public function sendEmail($user)
    {

        $users = User::whereHas('roles', function($q){
            $q->where('name', 'admin');
        })->get();

        foreach($users as $user){
            Mail::to($user->email)->queue(new PasswordResetMail($user));
        }

    }
}
