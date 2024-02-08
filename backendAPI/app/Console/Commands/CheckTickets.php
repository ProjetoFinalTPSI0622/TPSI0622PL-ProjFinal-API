<?php

namespace App\Console\Commands;

use App\Mail\TicketCreatedMail;
use App\Tickets;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for unhandled tickets and warns the admin if there are any.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all unhandled tickets
        $this->checkUnassignedTickets();


        return 0;
    }

    private function checkUnassignedTickets()
    {
        // Get all unassigned tickets
        $tickets = Tickets::whereHas('status', function ($q) {
            $q->where('status_name', 'Unassigned');
        })->get();

        if (count($tickets) > 0) {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            })->get();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new TicketCreatedMail($tickets));
            }
        }

        // Check for overdue tickets
        // | ID | Title | Description | CreatedBy | AssignedTo | DueDate | Status | Priority | Category |
        // |----|-------|-------------|-----------|------------|---------|--------|----------|----------|
        // | 1  |       |             |           |            |         |        |          |          |
        // | 2  |       |             |           |            |         |        |          |          |
    }

    private function checkOverdueTickets()
    {
        // Get all overdue tickets
        $tickets = Tickets::All()->where('assignedto', '!=', null)->where('dueDate', '<', now());

        if (count($tickets) > 0) {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            })->get();

            foreach($tickets as $ticket){
                $ticket->load('assignedto');
                Mail::to($ticket->assignedto->email)->send(new TicketCreatedMail($ticket));
            }

            foreach ($users as $user) {
                Mail::to($user->email)->send(new TicketCreatedMail($tickets));
            }
        }
    }

}
