<?php

namespace App\Http\Controllers;

use App\NotificationRecipient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationRecipientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $user = Auth::guard('api')->user();
        try{

            $notifications = NotificationRecipient::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            return response()->json($notifications, 200);
        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * Check if user has unread notifications
     *
     * @param  \App\NotificationRecipient  $notificationRecipient
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        $user = Auth::guard('api')->user();
        try{
            $unreadNotificationCount = NotificationRecipient::where('user_id', $user->id)->where('is_read', false)->count();

            if($unreadNotificationCount > 0){
                return response()->json(['response' => true, 'count' => $unreadNotificationCount], 200);
            }else{
                return response()->json(['response' => false], 200);
            }

        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
        }
    }
}