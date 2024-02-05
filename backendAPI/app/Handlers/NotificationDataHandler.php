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

        switch ($eventType) {
            case 'ticket_created':
                $this->data['ticket_id'] = $eventData['id'];
                $this->data['created_by'] = $eventData['createdby'];
                $this->data['ticket_title'] = $eventData['title'];
                $this->recipientList->addAllAdmins();
                break;

            case 'ticketStatusUpdated':
                $this->data['ticket_id'] = $eventData['id'];
                $this->data['updated_by'] = $eventData['updatedby'];
                $this->data['updated_to'] = $eventData['status']['name'];
                $this->recipientList->addAssignedTechnician($eventData['assignedto']['id']);
                $this->recipientList->addAllAdmins();
                $this->recipientList->addSpecificUser($eventData['createdby']['id']);
                break;

            case 'ticketPriorityUpdated':
                $this->data['ticket_id'] = $eventData['id'];
                $this->data['updated_by'] = $eventData['updatedby'];
                $this->data['updated_to'] = $eventData['priority']['name'];
                $this->recipientList->addAssignedTechnician($eventData['assignedto']['id']);
                $this->recipientList->addAllAdmins();
                $this->recipientList->addSpecificUser($eventData['createdby']['id']);
                break;

            case 'ticketCommentCreated':
                $this->data['ticket_id'] = $eventData['id'];
                $this->data['comment_id'] = $eventData['comment']['id'];
                $this->data['created_by'] = $eventData['comment']['createdby'];
                $this->data['comment'] = $eventData['comment']['comment'];
                $this->recipientList->addAssignedTechnician($eventData['assignedto']['id']);
                $this->recipientList->addAllAdmins();
                $this->recipientList->addSpecificUser($eventData['createdby']['id']);
                break;

            case 'ticketAssigned':
                $this->data['ticket_id'] = $eventData['id'];
                $this->data['assigned_to'] = $eventData['assignedto']['name'];
                $this->recipientList->addAssignedTechnician($eventData['assignedto']['id']);
                $this->recipientList->addAllAdmins();
                $this->recipientList->addSpecificUser($eventData['createdby']['id']);
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
