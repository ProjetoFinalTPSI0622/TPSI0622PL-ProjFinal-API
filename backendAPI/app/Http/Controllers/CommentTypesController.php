<?php

namespace App\Http\Controllers;

use App\CommentTypes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $commentTypes = CommentTypes::all();
            return response()->json($commentTypes, 200);
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
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $commentType = CommentTypes::create($request->all());
                return response()->json($commentType, 201);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        }
        else {
            return response()->json("Not logged in", 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommentTypes  $commentTypes
     * @return \Illuminate\Http\Response
     */
    public function show(CommentTypes $commentType)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                return response()->json($commentType, 200);
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
     * @param  \App\CommentTypes  $commentTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(CommentTypes $commentTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommentTypes  $commentTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommentTypes $commentType)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $commentType->update($request->all());
                return response()->json($commentType, 200);
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
     * @param  \App\CommentTypes  $commentTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentTypes $commentType)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $commentType->delete();
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
