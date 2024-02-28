<?php

namespace App\Handlers;

use App\Builders\NotificationRecipientListBuilder;

class NotificationDataHandler
{

    private $data = [];
    private $recipientList;

    public function __construct()
    {
        $this->recipientList = new NotificationRecipientListBuilder();
    }

    public function handleNotificationData($eventType, $eventData) : array
    {
        $this->data['event_type'] = $eventType;

        switch ($eventType) {
            case 'ticket_created':
                $this->data['ticket'] = $eventData;
                $this->recipientList->addAllAdmins();
                break;

            case 'ticketStatusUpdated':
                $this->data['ticket'] = $eventData;
                $this->data['updated_by'] = $eventData['updated_by'];
                $this->data['updated_to'] = $eventData['status'];
                $this->recipientList->addAssignedTechnician($eventData['assignedto']['id']??null);
                $this->recipientList->addAllAdmins();
                $this->recipientList->addSpecificUser($eventData['createdby']);
                break;

            case 'ticketPriorityUpdated':
                $this->data['ticket'] = $eventData;
                $this->data['updated_by'] = $eventData['updatedby'];
                $this->data['updated_to'] = $eventData['priority']['name'];
                $this->recipientList->addAssignedTechnician($eventData['assignedto']['id']);
                $this->recipientList->addAllAdmins();
                $this->recipientList->addSpecificUser($eventData['createdby']['id']);
                break;

            case 'ticketCommentCreated':
                $this->data['ticket'] = $eventData;
                $this->data['comment_id'] = $eventData['comment']['id'];
                $this->data['created_by'] = $eventData['comment']['createdby'];
                $this->data['comment'] = $eventData['comment']['comment'];
                $this->recipientList->addAssignedTechnician($eventData['assignedto']['id']);
                $this->recipientList->addAllAdmins();
                $this->recipientList->addSpecificUser($eventData['createdby']['id']);
                break;

            case 'ticket_assigned':
                $this->data['ticket'] = $eventData;
                $this->recipientList->addAssignedTechnician($eventData['assignedto']);
                $this->recipientList->addSpecificUser($eventData['createdby']);
                break;

            default:
                $this->data = [];
                $this->recipientList = [];
                break;
        }

        return [
            'data' => $this->data,
            //TODO: NO IDEA WHY THIS WORKS, BUT IT DOES
            'recipients' => $this->recipientList->getNotificationRecipients()
        ];
    }

}
