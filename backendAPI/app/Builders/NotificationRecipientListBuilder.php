<?php

namespace App\Builders;

use App\User;

class NotificationRecipientListBuilder
{
    private $notificationRecipients = [];

    public function _construct(){
        $this->notificationRecipients = [];
    }
    public function addAllAdmins(){

        $this->notificationRecipients = array_merge($this->notificationRecipients, User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->get()->toArray());

    }

    public function addAllTechnicians(){
        $this->notificationRecipients = array_merge($this->notificationRecipients, User::whereHas('roles', function ($q) {
            $q->where('name', 'technician');
        })->get()->toArray());
    }

    public function addAllTechniciansAndAdmins(){
        $this->addAllAdmins();
        $this->addAllTechnicians();
    }

    public function addSpecificUser($id)
    {
        $user = User::where('id', $id)->get();

        if(User::whereHas('roles', function ($q) {
            $q->where('name', 'user');
        })->where('id', $id)->exists()){
            $this->notificationRecipients = array_merge($this->notificationRecipients, $user->toArray());
        }
    }

    public function addAssignedTechnician($id){
        $this->notificationRecipients = array_merge($this->notificationRecipients, User::whereHas('roles', function ($q) {
            $q->where('name', 'technician');
        })->where('id', $id)->get()->toArray());
    }

    public function getNotificationRecipients(){
        return $this->notificationRecipients;
    }
}
