<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
        protected function authenticatedUser()
        {
            return auth()->user();
        }
    public function index()
    {
        $notifications =$this->authenticatedUser()->notifications()->latest()->paginate(10);

        return response()->json([
            'count' => $notifications->total(),
            'status' => 'success',
            'data' => $notifications
        ]);
    }
    public function unread()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->authenticatedUser()->unreadNotifications
        ]);
    }
    public function markAsRead($id)
    {
        $notification = $this->authenticatedUser()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read'
        ]);
    }
    public function markAllAsRead()
    {
        $this->authenticatedUser()->unreadNotifications->markAsRead();

        return response()->json([
            'status' => 'success',
            'message' => 'All notifications marked as read'
        ]);
    }
    public function destroy($id)
    {
        $notification = $this->authenticatedUser()->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification deleted'
        ]);
    }
}
