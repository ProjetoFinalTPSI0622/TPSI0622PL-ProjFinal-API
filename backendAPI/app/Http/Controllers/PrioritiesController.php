<?php

namespace App\Http\Controllers;

use App\Priorities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrioritiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('api')->check()) {

            try {
                $priorities = Priorities::all();
                return response()->json($priorities, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            return response()->json("Not authenticated", 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            if (Auth::guard('api')->user()->hasRole('admin')) {

                try {
                    $priority = Priorities::create($request->all());
                    return response()->json($priority, 201);
                } catch (Exception $exception) {
                    return response()->json(['error' => $exception], 500);
                }

            } else {
                // Return unauthorized response if not authenticated
                return response()->json("Not Enough Permissions", 401);
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Priorities $priorities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Priorities $priority)
    {
        if (Auth::guard('api')->user()->hasRole('admin')) {

            try {
                $priority->update($request->all());
                return response()->json($priority, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not Enough Permissions", 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Priorities $priorities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Priorities $priority)
    {
        if (Auth::guard('api')->user()->hasRole('admin')) {

            try {
                $priority->delete();
                return response()->json(['message' => 'Deleted'], 205);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not Enough Permissions", 401);
        }
    }
}
