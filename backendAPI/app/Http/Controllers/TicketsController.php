<?php

namespace App\Http\Controllers;

use App\Events\NewTicketCreated;
use App\Events\TicketUpdateEvent;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketShowRequest;
use App\Notifications\ticketCreated;
use App\Tickets;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin
                try {
                    // Retrieve all users
                    //$tickets = Tickets::all();

                    $tickets = Tickets::with('createdby', 'assignedto', 'status', 'category', 'priority' )->get();


                    // Return the list of users
                    return response()->json($tickets, 200);
                } catch (Exception $e) {
                    // Handle exceptions if any
                    return response()->json($e->getMessage(), 500);
                }
            } else {
                // Return unauthorized response if not authenticated
                return response()->json("Not Enough Permissions", 401);
            }
        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
        }
    }

    public function userTickets()
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            try {
                // Retrieve all users
                $tickets = Tickets::where('createdby', Auth::guard('api')->user()->id)->get();

                // Return the list of users
                return response()->json($tickets, 200);
            } catch (Exception $e) {
                // Handle exceptions if any
                return response()->json($e->getMessage(), 500);
            }
        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(TicketCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $ticket = new Tickets([
                'createdby' => Auth::guard('api')->user()->id,
                'assignedto' => null,
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'status' => 1,
                'priority' => $validatedData['priority'],
                'category' => $validatedData['category'],
            ]);
            try{

                $ticket->save();
                event(new NewTicketCreated($ticket));

            } catch (Exception $e) {
                // Handle exceptions if any
                return response()->json($e->getMessage(), 500);
            }
            return response()->json($ticket, 201);
        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tickets  $ticket
     * @return JsonResponse
     */
    public function show(Tickets $ticket)
    {
        try{

            $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority' );
        } catch (Exception $e) {

            return response()->json($e->getMessage(), 500);
        }

        try {
            return response()->json($ticket, 200);
        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tickets  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tickets $ticket)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin
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
                    $originalStatus = $ticket->status;
                    $ticket->update($validatedData);

                    if ($originalStatus != $ticket->status) {
                        event(new TicketUpdateEvent($ticket));
                    }

                    return response()->json($ticket, 200);
                } catch (Exception $e) {
                    // Handle exceptions if any
                    return response()->json($e->getMessage(), 500);
                }
            } else {
                // Return unauthorized response if not authenticated
                return response()->json("Not Enough Permissions", 401);
            }
        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
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
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin
                try {
                    $ticket->delete();
                    return response()->json(['message' => 'Ticket Deleted'], 205);
                } catch (Exception $e) {
                    // Handle exceptions if any
                    return response()->json($e->getMessage(), 500);
                }
            } else {
                // Return unauthorized response if not authenticated
                return response()->json("Not Enough Permissions", 401);
            }
        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
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
