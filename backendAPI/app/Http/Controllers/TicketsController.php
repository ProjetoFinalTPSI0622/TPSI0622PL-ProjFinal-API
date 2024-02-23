<?php

namespace App\Http\Controllers;

use App\Attachments;
use App\Events\NewTicketCreated;
use App\Events\NotificationEvent;
use App\Events\TicketAssignedEvent;
use App\Events\TicketCreatedEvent;
use App\Events\TicketStatusChangedEvent;
use App\Events\TicketUpdateEvent;
use App\Handlers\NotificationDataHandler;
use App\Handlers\RecipientHandler;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketShowRequest;
use App\Mail\TicketCreatedMail;
use App\Notifications\ticketCreated;
use App\Statuses;
use App\Priorities;
use App\Tickets;
use App\UserInfo;
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
     * @return JsonResponse
     */
    public function index()
    {
            try {

                $tickets = Tickets::with(['createdby' => function($query) {
                    $query->with('userInfo');
                }, 'assignedto', 'status', 'category', 'priority'])
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();

                foreach($tickets as &$ticket) {

                $ticket['createdby']['user_info']['profile_picture_path'] = Storage::disk('public')->url($ticket['createdby']['user_info']['profile_picture_path']);
                }

                json_encode($tickets);
                // Return the list of users
                return response()->json($tickets, 200);
            } catch (Exception $e) {
                // Handle exceptions if any
                return response()->json($e->getMessage(), 500);
            }

    }

    public function userTickets()
    {
        try {
            // Retrieve all tickets
            $tickets = Tickets::where('createdby', Auth::guard('api')->user()->id)->get();
            $tickets->load('createdby', 'assignedto', 'status', 'category', 'priority');

            // Return the list of tickets
            return response()->json($tickets, 200);
        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
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

                if ($request->hasFile('files')) {
                    foreach ($request->file('files') as $file) {
                        $path = Storage::disk('public')->put('tickets', $file);

                        $attachment = new Attachments([
                            'FileName' => $file->getClientOriginalName(),
                            'FileType' => $file->getClientMimeType(),
                            'FilePath' => $path,
                            'FileSize' => $file->getSize(),
                        ]);

                        $attachment->save();
                        $ticket->attachments()->attach($attachment);

                    }
                }

                try {
                    $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority', 'attachments');
                    event(new TicketCreatedEvent($ticket));
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                }

            } catch (Exception $e) {
                // Handle exceptions if any
                return response()->json($e->getMessage(), 500);
            }
            return response()->json($ticket->load('attachments'), 200);
        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Tickets $ticket
     * @return JsonResponse
     */
    public function show(Tickets $ticket)
    {

        if(!(Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->hasRole('technician'))) {

            if ($ticket->createdby != Auth::guard('api')->user()->id) {
                return response()->json('Not enough permissions', 400);
            }
        }
        try {

            $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority', 'attachments');

            foreach ($ticket->attachments as $attachment) {
                $attachmentPath = $attachment->FilePath;
                if (!Str::startsWith($attachmentPath, 'http')) {
                    $attachment->FilePath = Storage::disk('public')->url($attachmentPath);
                }
            }

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
     * Remove the specified resource from storage.
     *
     * @param Tickets $tickets
     * @return JsonResponse
     */
    public function destroy(Tickets $ticket)
    {
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
    }


    /**
     * Search for a ticket
     *
     * @param Tickets $tickets
     * @return \Illuminate\Http\Response
     */
    /*public function search(Request $request)
    {

    TODO:  se nao for ser usado apagar

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
    }*/

    /**
     * Fetch ticket comments
     *
     * @param Tickets $ticket
     * @return JsonResponse
     */
    public function ticketComments(Tickets $ticket)
    {
        try {
            $ticket->load('comments.user.userInfo', 'comments.attachments', 'comments.commentType');

            $user = Auth::guard('api')->user();
            $userIsAdminOrTechnician = $user->hasRole('admin') || $user->hasRole('technician');

            $comments = $ticket->comments->filter(function ($comment) use ($userIsAdminOrTechnician) {
                if ($userIsAdminOrTechnician) {
                    return true;
                }
                return $comment->commentType->name === 'Public';
            });

            foreach ($comments as $comment) {
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

            $response = $ticket->toArray();
            $response['comments'] = $comments->values()->toArray();

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
        return response()->json($response, 200);
    }


    /**
     * Assigns a technician to a ticket
     *
     * @param Tickets $ticket
     * @param User $technician
     * @return JsonResponse
     */
    public function assignTechnician(Tickets $ticket, User $technician)
    {
        if(Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->hasRole('technician')) {

            $technician->load('roles');

            if (!$technician->hasRole('technician')) {
                return response()->json('User is not a technician', 400);
            }

            $ticket->assignedto = $technician->id;
            $ticket->save();

            $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority', 'attachments');
            event(new TicketAssignedEvent($ticket));
            return response()->json($ticket, 200);
        } else {
            return response()->json('Not enough permissions', 400);
        }

    }


    /**
     * Change ticket status
     *
     * @param Tickets $ticket
     * @param Statuses $status
     * @return JsonResponse
     */
    public function changeStatus(Tickets $ticket, Statuses $status)
    {
        if(Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->hasRole('technician')) {
            try{

            $ticket->status = $status->id;
            $ticket->save();
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
            try{
                $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority');
                $ticket['updated_by'] = Auth::guard('api')->user();
                event(new TicketStatusChangedEvent($ticket));
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
            return response()->json($ticket, 200);
        } else {
            return response()->json('Not enough permissions', 400);
        }
    }

    public function changePriority(Tickets $ticket, Priorities $priority)
    {
        if(Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->hasRole('technician')) {
            try{
                $ticket->priority = $priority->id;
                $ticket->save();
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
            try{
                $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority');
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
            return response()->json($ticket, 200);
        } else {
            return response()->json('Not enough permissions', 400);
        }
    }

    public function closeTicket(Tickets $ticket){
        if(Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->hasRole('technician')) {
            try{
                $ticket->status = Statuses::where('name', 'Completo')->first()->id;
                $ticket->save();
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
            try{
                $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority');
                event(new TicketStatusChangedEvent($ticket));
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
            return response()->json($ticket, 200);
        } else {
            return response()->json('Not enough permissions', 400);
        }
    }

    public function reopenTicket(Tickets $ticket){
        if(Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->hasRole('technician')) {
            try{
                $ticket->status = Statuses::where('name', 'Pendente')->first()->id;
                $ticket->save();
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
            try{
                $ticket->load('createdby', 'assignedto', 'status', 'category', 'priority');
                $ticket['updated_by'] = Auth::guard('api')->user()->id;
                event(new TicketStatusChangedEvent($ticket));
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
            return response()->json($ticket, 200);
        } else {
            return response()->json('Not enough permissions', 400);
        }
    }
}
