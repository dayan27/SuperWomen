<?php

namespace App\Http\Controllers\UserAccount;

use App\Http\Controllers\Controller;
use App\Models\request as ModelsRequest;
use App\Models\Subscription;
use App\Models\SubscriptionEmail;
use Illuminate\Http\Request;

class SubscriptionEmailController extends Controller
{
    public function subscribe_email(){

        $exist=SubscriptionEmail::find(request()->email);
        if($exist)
          return response()->json('already subscribed',201);
        $email=new SubscriptionEmail();
        $email->email=request()->email;
        $email->first_name=request()->first_name;
        $email->last_name=request()->last_name;
        $email->save();
        return response()->json('subscribed',200);

    }
}
