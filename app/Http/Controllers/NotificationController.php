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
        $noti=$emp->unreadNotifications()->where('id',$id)->first();
        if ($noti) {
         $noti->markAsRead();
         return response()->json('success',200);

        }else{
            return response()->json('already marked',201);

        }

    }


    public function markAllAsSeen(){

        $emp=request()->user();
        $notifications=  $emp->notifications;

        foreach($notifications as $not){
            $not->updated_at=null;
            $not->save();
        }


       return $emp->notifications;
        ///
}

}
