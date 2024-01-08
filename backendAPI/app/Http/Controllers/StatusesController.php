<?php

namespace App\Http\Controllers;

use App\Statuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard("api")->check()) {
            if (Auth::guard("api")->user()->hasRole("admin")) {
                try {
                    $statuses = Statuses::all();
                    return response()->json($statuses, 200);
                } catch (Exception $exception) {
                    return response()->json(["error" => $exception], 500);
                }
            } else {
                return response()->json("Not enough permissions", 401);
            }
        } else {
            return response()->json("Not authenticated", 401);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statuses  $statuses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statuses $status)
    {
        if (Auth::guard("api")->check()) {
            if (Auth::guard("api")->user()->hasRole("admin")) {
                try {
                    $status->update($request->all());
                    return response()->json($status, 200);
                } catch (Exception $exception) {
                    return response()->json(["error" => $exception], 500);
                }
            } else {
                return response()->json("Not enough permissions", 401);
            }
        } else {
            return response()->json("Not authenticated", 401);
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
        if (Auth::guard("api")->check()) {
            if (Auth::guard("api")->user()->hasRole("admin")) {
                try {
                    $status->delete();
                    return response()->json(["message" => "Deleted"], 205);
                } catch (Exception $exception) {
                    return response()->json(["error" => $exception], 500);
                }
            } else {
                return response()->json("Not enough permissions", 401);
            }
        } else {
            return response()->json("Not authenticated", 401);
        }
    }
}
