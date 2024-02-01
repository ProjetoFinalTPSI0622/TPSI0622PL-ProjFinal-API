<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickets;
use App\User;

class DashboardController extends Controller
{
    public function getTicketsPerDay(){

        $stats = Tickets::selectRaw('DAYNAME(created_at) as day, count(*) as total')
        ->groupBy('day')
        ->get();

        return response()->json($stats, 200);
    }

    public function getStatsByStatus()
    {
        $stats = Tickets::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get();
        return response()->json($stats);
    }



}
