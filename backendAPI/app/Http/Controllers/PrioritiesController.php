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
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

                try {
                    $priorities = Priorities::all();
                    return response()->json($priorities, 200);
                } catch (Exception $exception) {
                    return response()->json(['error' => $exception], 500);
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
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

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
        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
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
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

                try {
                    return response()->json($priority, 200);
                } catch (Exception $exception) {
                    return response()->json(['error' => $exception], 500);
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
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

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
        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
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
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

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
        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
        }

    }
}
