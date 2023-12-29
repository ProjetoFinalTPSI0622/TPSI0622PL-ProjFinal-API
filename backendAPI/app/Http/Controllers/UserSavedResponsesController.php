<?php

namespace App\Http\Controllers;

use App\User;
use App\UserSavedResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSavedResponsesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if(Auth::check()){ // Check if user is logged in
            try {
                $user = User::find(Auth::id());
                return response()->json($user->savedResponses, 200);
            }
            catch (Exception $e) {
                return response()->json($e, 500);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if(Auth::check()){ // Check if user is logged in
            try {
                $user = User::find(Auth::id());
                $userSavedResponses = new UserSavedResponses();
                $userSavedResponses->user_id = $user->id;
                $userSavedResponses->response_text = $request->response_text;
                $userSavedResponses->save();
                return response()->json($userSavedResponses, 200);
            }
            catch (Exception $e) {
                return response()->json($e, 500);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserSavedResponses  $userSavedResponses
     * @return \Illuminate\Http\Response
     */
    public function show(UserSavedResponses $userSavedResponses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSavedResponses  $userSavedResponses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSavedResponses $userSavedResponses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSavedResponses  $userSavedResponses
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSavedResponses $userSavedResponses)
    {
        //
    }
}
