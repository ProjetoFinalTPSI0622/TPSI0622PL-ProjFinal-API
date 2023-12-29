<?php

namespace App\Http\Controllers;

use App\Attachments;
use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $attachments = Attachments::all();
            return response()->json($attachments, 200);
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
            $attachment = Attachments::create($request->all());
            return response()->json($attachment, 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
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
        try {
            return response()->json($attachment, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
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
        try {
            $attachment->update($request->all());
            return response()->json($attachment, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
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
        try {
            $attachment->delete();
            return response()->json(['message' => 'Deleted'], 205);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
