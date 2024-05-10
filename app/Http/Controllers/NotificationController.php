<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;;
use App\Http\Resources\NotificationResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $unreadNotifications = $user->notifications()
                            ->wherePivot('is_read', false)
                            ->get();
        $data = NotificationResource::collection($unreadNotifications);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function read(Notification $notification)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->notifications()->updateExistingPivot($notification, ['is_read' => true]);
        return response()->json(['message' => 'Done!']);
    }
}
