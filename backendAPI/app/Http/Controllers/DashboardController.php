<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tickets;
use App\Statuses;

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
        $stats = \DB::table('tickets')
            ->join('statuses', 'tickets.status', '=', 'statuses.id')
            ->select('statuses.status_name', \DB::raw('count(*) as total'))
            ->groupBy('statuses.status_name')
            ->get();

        return response()->json($stats);
    }



}
