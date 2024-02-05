<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Http\Requests\CommentStoreRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentStoreRequest $request)
    {
        try{
            $validatedComment = $request->validated();
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        try{
            $user = Auth::guard('api')->user();

            try{

            $comment = new Comments([
                'ticket_id' => $validatedComment['ticket_id'],
                'user_id' => $user->id,
                'comment_type' => $validatedComment['comment_type'] ?? 1,
                'comment_body' => $validatedComment['comment_body']
            ]);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 500);
            }
            try{

                $comment->save();
            } catch (Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 500);
            }

            return response()->json($comment, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
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
