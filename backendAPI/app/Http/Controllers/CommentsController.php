<?php

namespace App\Http\Controllers;

use App\Attachments;
use App\Comments;
use App\Http\Requests\CommentStoreRequest;
use App\Tickets;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentStoreRequest $request)
    {
        $ticket = Tickets::with('createdby')->findOrFail($request->ticket_id);

        if (Auth::guard('api')->user()->hasRole('admin')
            || Auth::guard('api')->user()->hasRole('technician')
            || Auth::guard('api')->user()->id == $ticket->createdby) {

            try {

                $validatedComment = $request->validated();
            } catch (Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 500);
            }

            try {
                $user = Auth::guard('api')->user();

                try {

                    $comment = new Comments([
                        'ticket_id' => $validatedComment['ticket_id'],
                        'user_id' => $user->id,
                        'comment_type' => $validatedComment['comment_type'] ?? 1,
                        'comment_body' => $validatedComment['comment_body']
                    ]);
                } catch (Exception $exception) {
                    return response()->json(['error' => $exception->getMessage()], 500);
                }
                try {

                    $comment->save();

                    if ($request->hasFile('files')) {
                        foreach ($request->file('files') as $file) {
                            $path = Storage::disk('public')->put('attachments', $file);

                            $attachment = new Attachments([
                                'FileName' => $file->getClientOriginalName(),
                                'FileType' => $file->getClientMimeType(),
                                'FilePath' => $path,
                                'FileSize' => $file->getSize(),
                            ]);

                            $attachment->save();
                            $comment->attachments()->attach($attachment);

                        }
                    }

                } catch (Exception $exception) {
                    return response()->json(['error' => $exception->getMessage()], 500);
                }

                return response()->json($comment->load('attachments'), 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 500);
            }

        } else {
            return response()->json("Not authorized", 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Comments $comment
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

        } else {
            return response()->json("Not logged in", 401);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Comments $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comments $comment)
    {
        if (Auth::guard('api')->user()->hasRole('admin')
            || Auth::guard('api')->user()->hasRole('technician')
            || Auth::guard('api')->user()->id == $comment->user_id) {

            try {
                if ($comment->attachments) {
                    foreach ($comment->attachments as $attachment) {
                        Storage::disk('public')->delete($attachment->FilePath);
                        $attachment->delete();
                    }
                }

                $comment->attachments()->detach();
                $comment->delete();
                return response()->json(['message' => 'Deleted'], 205);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else { // If user is not authorized
            return response()->json("Not authorized", 401);
        }
    }
}
