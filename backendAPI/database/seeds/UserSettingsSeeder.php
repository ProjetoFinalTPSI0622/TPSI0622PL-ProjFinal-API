<?php

use App\User;
use App\UserSettings;
use Illuminate\Database\Seeder;

class UserSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::all() as $user) {
            $userSettings = new UserSettings();
            $userSettings->user_id = $user->id;
            $userSettings->ticket_created = true;
            $userSettings->ticket_assigned = true;
            $userSettings->ticket_status_updated = true;
            $userSettings->ticket_priority_updated = true;
            $userSettings->ticket_commented = true;
            $userSettings->save();
        }
    }
}
