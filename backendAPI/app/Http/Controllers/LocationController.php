<?php

namespace App\Http\Controllers;

use App\Location;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $locations = Location::all();
                return response()->json($locations, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin

                try {
                    $location = Location::create($request->all());
                    return response()->json($location, 201);
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
     * @param  \App\Location  $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Location $location)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                return response()->json($location, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Location $location)
    {
        if (Auth::guard('api')->check()) {
            if (Auth::guard('api')->user()->hasRole('admin')) {

                try {
                    $location->delete();
                    return response()->json(['message' => 'Deleted'], 205);
                } catch (Exception $exception) {
                    return response()->json(['error' => $exception], 500);
                }

            } else {
                return response()->json("Not Enough Permissions", 401);
            }
        } else {
            return response()->json("Not authenticated", 401);
        }
    }
}
