<?php

namespace App\Http\Controllers;

use App\Tickets;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {                                       //ver as relaçoes no model
            $tickets = Tickets::all();
            return response()->json($tickets, 200);
            //return response()->json(Tickets::with(['status','priority','category'])->get(), 200);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
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
            $request->validate([
                'createdby' => 'required|exists:users,id',
                'assignedto' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|exists:statuses,id',
                'priority' => 'required|exists:priorities,id',
                'category' => 'required|exists:categories,id',
            ]);

            $ticket = Tickets::create($request->all());

            return response()->json($ticket, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar ticket', 'details' => $e->getMessage()], 500);        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function show(Tickets $ticket)
    {
        try {
         return response()->json($ticket, 200);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tickets $ticket)
    {
        try {
            $validatedData = $request->validate([
                'createdby' => 'required|exists:users,id',
                'assignedto' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|exists:statuses,id',
                'priority' => 'required|exists:priorities,id',
                'category' => 'required|exists:categories,id',
            ]);
            $ticket->update($validatedData);
            return response()->json($ticket, 200);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tickets $ticket)
    {
        try {
            $ticket->delete();
            return response()->json(['message' => 'Ticket Deleted'], 205);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }


    public function search(Request $request)
    {
        try {
            $request->validate([
                'search' => 'required|string|max:255',
            ]);
            $search = $request->input('search');
            $tickets = Tickets::where('title', 'like', '%'.$search.'%')->get();
            return response()->json($tickets, 200);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
