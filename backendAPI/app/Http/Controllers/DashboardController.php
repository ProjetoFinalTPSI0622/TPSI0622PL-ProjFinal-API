<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tickets;
use App\Statuses;

use App\User;

class DashboardController extends Controller
{


    public function getTicketsPerDay() {
        $createdStats = Tickets::selectRaw('DAYNAME(created_at) as day, count(*) as total')
            ->groupBy('day')
            ->get();

        $completedStats = Tickets::whereHas('status', function ($query) {
            $query->where('name', 'Completed');
        })
            ->selectRaw('DAYNAME(created_at) as day, count(*) as total')
            ->groupBy('day')
            ->get();

        return response()->json([
            'created' => $createdStats,
            'completed' => $completedStats
        ], 200);
    }

    public function getTicketsPerMonth() {
        $createdStats = Tickets::selectRaw('MONTHNAME(created_at) as month, count(*) as total')
            ->groupBy('month')
            ->get();

        $completedStats = Tickets::whereHas('status', function ($query) {
            $query->where('name', 'Completed');
        })
            ->selectRaw('MONTHNAME(created_at) as month, count(*) as total')
            ->groupBy('month')
            ->get();

        return response()->json([
            'created' => $createdStats,
            'completed' => $completedStats
        ], 200);
    }

    public function getStatsByStatus()
    {
        $stats = \DB::table('tickets')
            ->join('statuses', 'tickets.status', '=', 'statuses.id')
            ->select('statuses.name', \DB::raw('count(*) as total'))
            ->groupBy('statuses.name')
            ->get();

        return response()->json($stats);
    }

    public function getTicketStats(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $groupBy = $request->input('groupBy', 'day'); // Valor padrão é 'day'

        if ($groupBy == 'month') {
            // Lógica para agrupar por mês
        } else {
            // Lógica para agrupar por dia
            $stats = Tickets::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('DAYNAME(created_at) as day, count(*) as total')
                ->groupBy('day')
                ->get();
        }

        // Adicionar lógica para tickets resolvidos, se necessário

        return response()->json($stats, 200);
    }

    public function getResolutionTimePerCategory() {
        $stats = Tickets::selectRaw('categories.name as category, AVG(TIMESTAMPDIFF(HOUR, tickets.created_at, tickets.updated_at)) as average_resolution_time')
            ->join('categories', 'tickets.category', '=', 'categories.id')
            ->join('statuses', 'tickets.status', '=', 'statuses.id')
            ->where('statuses.name', '=', 'completed')
            ->groupBy('categories.name')
            ->get();

        return response()->json($stats, 200);
    }

}
