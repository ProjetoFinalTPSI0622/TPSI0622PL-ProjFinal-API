<?php

namespace App\Http\Controllers;

use App\Genders;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GendersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $genders = Genders::all();
                return response()->json($genders, 200);

            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        }
        else {
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
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

                try {
                    $gender = Genders::create($request->all());
                    return response()->json($gender, 201);
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
     * @param  \App\Genders  $genders
     * @return JsonResponse
     */
    public function show(Genders $gender)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                return response()->json($gender, 200);
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
     * @param  \App\Genders  $genders
     * @return \Illuminate\Http\Response
     */
    public function edit(Genders $genders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genders  $genders
     * @return JsonResponse
     */
    public function update(Request $request, Genders $gender)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

                try {
                    $gender->update($request->all());
                    return response()->json($gender, 200);
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
     * @param  \App\Genders  $genders
     * @return JsonResponse
     */
    public function destroy(Genders $gender)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

                try {
                    $gender->delete();
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
