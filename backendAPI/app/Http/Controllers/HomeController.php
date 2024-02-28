<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ticket = \App\Tickets::find(1);
        $ticket->load('createdby', 'assignedto', 'comments', 'status', 'priority', 'category' );
        return view('emails.ticket-created')->with('ticket', $ticket);
    }
}
