<?php

namespace App\Http\Controllers;

use App\Priorities;
use Illuminate\Http\Request;

class PrioritiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $priorities = Priorities::all();
            return response()->json($priorities, 200);
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
            $priority = Priorities::create($request->all());
            return response()->json($priority, 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Priorities  $priorities
     * @return \Illuminate\Http\Response
     */
    public function show(Priorities $priority)
    {
        try {
            return response()->json($priority, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Priorities  $priorities
     * @return \Illuminate\Http\Response
     */
    public function edit(Priorities $priorities)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Priorities  $priorities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Priorities $priority)
    {
        try {
            $priority->update($request->all());
            return response()->json($priority, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Priorities  $priorities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Priorities $priority)
    {
        try {
            $priority->delete();
            return response()->json(['message' => 'Deleted'], 205);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
