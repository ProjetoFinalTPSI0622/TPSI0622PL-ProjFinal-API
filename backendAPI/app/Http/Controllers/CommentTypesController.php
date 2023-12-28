<?php

namespace App\Http\Controllers;

use App\CommentTypes;
use Illuminate\Http\Request;

class CommentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
        try {
            $commentType = CommentTypes::create($request->all());
            return response()->json($commentType, 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
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
        try {
            return response()->json($commentType, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
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
        try {
            $commentType->update($request->all());
            return response()->json($commentType, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
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
        try {
            $commentType->delete();
            return response()->json(['message' => 'Deleted'], 205);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
