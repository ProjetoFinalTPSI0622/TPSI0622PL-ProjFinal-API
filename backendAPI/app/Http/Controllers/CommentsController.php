<?php

namespace App\Http\Controllers;

use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $comments = Comments::all();
                return response()->json($comments, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        }
        else {
            return response()->json("Not logged in", 401);
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
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $comment = Comments::create($request->all());
                return response()->json($comment, 201);
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
     * @param  \App\Comments  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comments $comment)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                return response()->json($comment, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        }
        else {
            return response()->json("Not logged in", 401);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comments  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comments $comment)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $comment->update($request->all());
                return response()->json($comment, 200);
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
     * @param  \App\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comments $comments)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in

            try {
                $comments->delete();
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
