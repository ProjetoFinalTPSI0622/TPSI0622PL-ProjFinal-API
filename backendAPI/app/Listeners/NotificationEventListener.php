<?php

namespace App\Listeners;

use App\Notification;
use App\NotificationRecipient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationEventListener
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
        $notificationId = $this->saveNotification($event->eventData);
        $this->notifyRecipients($notificationId, $event->eventData['recipients']);
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

}
