<?php

namespace App\Listeners;

use App\Handlers\NotificationDataHandler;
use App\Mail\TicketCreatedMail;
use App\Notification;
use App\NotificationRecipient;
use App\Tickets;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TicketCreatedEventListener
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
    public function handle(object $event)
    {
        $ticket = $this->handleData($event->ticket);
        $notificationId = $this->saveNotification($ticket);
        $this->notifyRecipients($notificationId, $ticket['recipients']);

        //TODO: UNCOMMENT THIS IN PROD TO NOT WASTE EMAIL QUOTA DURING TESTS
        //$this->sendEmail($event->ticket);
    }

    public function saveNotification($notificationData) {
        $notification = new Notification();
        $notification->notification_data = json_encode($notificationData['data']);
        $notification->save();
        return $notification->id;
    }

    protected function notifyRecipients($notificationId, $recipients){
        foreach($recipients as $recipient){
            $notificationRecipient = new NotificationRecipient();
            $notificationRecipient->notification_id = $notificationId;
            $notificationRecipient->user_id = $recipient['id'];
            $notificationRecipient->save();
        }
    }

    public function sendEmail($ticket)
    {
        $ticket->load('createdby');

        $users = User::whereHas('roles', function($q){
            $q->where('name', 'admin');
        })->get();

        Mail::to('fabiomiguel3.10@gmail.com')->send(new TicketCreatedMail($ticket));

        foreach($users as $user){
            Mail::to($user->email)->send(new TicketCreatedMail($ticket));
        }
    }

    public function handleData($ticket): array
    {
        $handler = new NotificationDataHandler();
        return $handler->handleNotificationData('ticket_created', $ticket);
    }
}
