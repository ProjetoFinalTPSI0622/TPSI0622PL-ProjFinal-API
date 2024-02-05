<?php

namespace App\Http\Controllers;

use App\Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function attachmentsTicket($ticket_id)
    {
        if (Auth::guard('api')->check()) { // Verifica se o usuário está logado

            try {
                $attachments = Attachments::where('ticket_id', $ticket_id)->get();

                $files = [];
                foreach ($attachments as $attachment) {
                    $files[] = [
                        'FileName' => $attachment->FileName,
                        'FileType' => $attachment->FileType,
                        'FilePath' => $attachment->FilePath,
                        'FileSize' => $attachment->FileSize,
                        'Link' => Storage::url($attachment->FilePath),
                    ];
                }

                return response()->json($files, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 500);
            }

        } else {
            return response()->json("Not logged in", 401);
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
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $file = $request->file('file');
                $path = Storage::disk('public')->put('attachments', $file);
                $attachment = Attachments::create([

                    'ticket_id' => $request->ticket_id,
                    'FileName' => $file->getClientOriginalName(),
                    'FilePath' => $path,
                    'FileType' => $file->getClientMimeType(),
                    'FileSize' => $file->getSize(),
                ]);

                return response()->json($attachment, 201);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 500);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attachments  $attachments
     * @return \Illuminate\Http\Response
     */
    public function show(Attachments $attachment)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                return response()->download(storage_path('app/' . $attachment->FilePath));
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachments  $attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachments $attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachments  $attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachments $attachment)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            try {
                $attachment->update($request->all());
                return response()->json($attachment, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachments  $attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachments $attachment)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                Storage::delete($attachment->FilePath);
                $attachment->delete();
                return response()->json(['message' => 'Deleted'], 205);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        }
        else {
            return response()->json("Not logged in", 401);
        }
    }
}
