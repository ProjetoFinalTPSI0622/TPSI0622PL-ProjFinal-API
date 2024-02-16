<?php

namespace App\Listeners;

use App\Handlers\NotificationDataHandler;
use App\Mail\TicketStatusMail;
use App\Notification;
use App\NotificationRecipient;
use App\Tickets;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TicketStatusChangedListener
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
        $notificationData = $this->handleData($event->ticket);
        $notificationId = $this->saveNotification($notificationData);
        $this->notifyRecipients($notificationId, $notificationData['recipients']);

        $this->sendEmail($event->ticket);
    }

    public function saveNotification($notificationData)
    {
        $notification = new Notification();
        $notification->notification_data = json_encode($notificationData['data']);
        $notification->save();
        return $notification->id;
    }

    protected function notifyRecipients($notificationId, $recipients)
    {
        foreach ($recipients as $recipient) {
            $notificationRecipient = new NotificationRecipient();
            $notificationRecipient->notification_id = $notificationId;
            $notificationRecipient->user_id = $recipient['id'];
            $notificationRecipient->save();
        }
    }

    public function sendEmail($ticket)
    {
        $ticket->load('createdby');

        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();

    foreach ($users as $user) {
            Mail::to($user->email)->queue(new TicketStatusMail($ticket));
            Mail::to('danielpereira22costa@gmail.com')->queue(new TicketStatusMail($ticket));

        }
    }

    public function handleData($ticket): array
    {
        $handler = new NotificationDataHandler();
        return $handler->handleNotificationData('ticketStatusUpdated', $ticket);
    }
}
