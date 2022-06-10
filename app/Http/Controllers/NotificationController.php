<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAllAsRead(){

            $emp=request()->user();
            $emp->unreadNotifications->markAsRead();

            ////


           return $emp->notifications;
            ///
    }
    public function markOneAsRead($id){
        $emp=request()->user();
        $emp->unreadNotifications()->where('id',$id)->first()->markAsRead();
        return response()->json('success',200);

    }


    public function markAllAsSeen(){

        $emp=request()->user();
        $notifications=  $emp->notifications;

        foreach($notifications as $not){
            
        }


       return $emp->notifications;
        ///
}

}
