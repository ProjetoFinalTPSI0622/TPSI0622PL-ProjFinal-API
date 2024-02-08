<?php

namespace App\Http\Controllers;

use App\Events\NewTicketCreated;
use App\Events\NotificationEvent;
use App\Events\TicketCreatedEvent;
use App\Events\TicketStatusChangedEvent;
use App\Events\TicketUpdateEvent;
use App\Handlers\NotificationDataHandler;
use App\Handlers\RecipientHandler;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketShowRequest;
use App\Mail\TicketCreatedMail;
use App\Notifications\ticketCreated;
use App\Tickets;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

//TODO: delete this after
use Illuminate\Support\Facades\Log;


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

                    $tickets = Tickets::with('createdby', 'assignedto', 'status', 'category', 'priority')->get();


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
     * @param \Illuminate\Http\Request $request
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
            try {

                $ticket->save();

                try {
                    event(new TicketCreatedEvent($ticket));
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                }

            } catch (Exception $e) {
                // Handle exceptions if any
                return response()->json($e->getMessage(), 500);
            }
            return response()->json($ticket, 200);
        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Tickets $ticket
     * @return JsonResponse
     */
    public function show(Tickets $ticket)
    {
        try {

            $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority');
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Tickets $ticket
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
     * @param \App\Tickets $tickets
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
            $tickets = Tickets::where('title', 'like', '%' . $search . '%')->get();
            return response()->json($tickets, 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    public function ticketComments(Tickets $ticket)
    {
        try {
            $ticket->load('comments.user.userInfo', 'comments.attachments');

            foreach ($ticket->comments as $comment) {
                if ($comment->user && $comment->user->userInfo) {
                    $path = $comment->user->userInfo->profile_picture_path;
                    if (!Str::startsWith($path, 'http')) {
                        $comment->user->userInfo->profile_picture_path = Storage::disk('public')->url($path);
                    }
                }

                foreach ($comment->attachments as $attachment) {
                    $attachmentPath = $attachment->FilePath;
                    if (!Str::startsWith($attachmentPath, 'http')) {
                        $attachment->FilePath = Storage::disk('public')->url($attachmentPath);
                    }
                }
            }

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
        return response()->json($ticket, 200);
    }

    public function changeStatus(Request $request, Tickets $ticket)
    {
        try {
            $request->validate([
                'status' => 'required|exists:statuses,id',
            ]);
            $originalStatus = $ticket->status;
            $ticket->status = $request->input('status');
            $ticket->save();

            if ($originalStatus != $ticket->status) {
                event(new TicketStatusChangedEvent($ticket));
            }

            return response()->json($ticket, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
