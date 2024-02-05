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
            $notifications->load('notification');

            foreach($notifications as $notification){
                $notificationData = json_decode($notification->notification->notification_data);
                $notification->notification->notification_data = $notificationData;
            }

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

    public function markAllAsRead()
    {
        $user = Auth::guard('api')->user();
        try{
            $notifications = NotificationRecipient::where('user_id', $user->id)->where('is_read', false)->get();
            foreach($notifications as $notification){
                $notification->is_read = true;
                $notification->save();
            }
            return response()->json(['response' => true], 200);
        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
        }
    }

    public function markAsRead($id)
    {
        $user = Auth::guard('api')->user();
        try{
            $notification = NotificationRecipient::where('user_id', $user->id)->where('id', $id)->first();
            $notification->is_read = true;
            $notification->save();
            return response()->json(['response' => true], 200);
        } catch (Exception $e) {
            // Handle exceptions if any
            return response()->json($e->getMessage(), 500);
        }
    }
}
