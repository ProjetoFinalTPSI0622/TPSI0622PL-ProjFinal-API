<?php

namespace App\Http\Controllers;

use App\Statuses;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $statuses = Statuses::all();
            return response()->json($statuses, 200);
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
            $status = Statuses::create($request->all());
            return response()->json($status, 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statuses  $statuses
     * @return \Illuminate\Http\Response
     */
    public function show(Statuses $status)
    {
        try {
            return response()->json($status, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Statuses  $statuses
     * @return \Illuminate\Http\Response
     */
    public function edit(Statuses $statuses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statuses  $statuses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statuses $status)
    {
        try {
            $status->update($request->all());
            return response()->json($status, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Statuses  $statuses
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statuses $status)
    {
        try {
            $status->delete();
            return response()->json(['message' => 'Deleted'], 205);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
