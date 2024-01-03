<?php

namespace App\Http\Controllers;

use App\TicketHistory;
use Illuminate\Http\Request;

class TicketHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $ticketHistory = TicketHistory::all();
            return response()->json($ticketHistory, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $ticketHistory = TicketHistory::create($request->all());
            return response()->json($ticketHistory, 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TicketHistory  $ticketHistory
     * @return \Illuminate\Http\Response
     */
    public function show(TicketHistory $ticketHistory)
    {
        try {
            return response()->json($ticketHistory, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketHistory  $ticketHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketHistory $ticketHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketHistory  $ticketHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketHistory $ticketHistory)
    {
        try {
            $ticketHistory->update($request->all());
            return response()->json($ticketHistory, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TicketHistory  $ticketHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketHistory $ticketHistory)
    {
        try {
            $ticketHistory->delete();
            return response()->json(['message' => 'Deleted'], 205);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
