<?php
namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

trait SendToken{

public function sendResetToken($code,$phone){
        
  $permited_phone=substr($phone,1);

    $response = Http::get('https://sms.hahucloud.com/api/send', [
      'key' => '0ad9035adfad0313a213ebb3ab4c7e64ab399a8c',
      'phone' =>  $permited_phone,
      'message' => 'Ur Otp '.$code,
      'device'=>'145'
  ]);


  if($response->ok()){
    return 'sent';

  }else{
    return 'error while sending otp';
  }

  // Send an SMS using Twilio's REST API and PHP
        $sid = "ACa97d1266e9ecff907c2745c7e54de647"; // Your Account SID from www.twilio.com/console
        $token = "66eeaa3c11451907cc7c1bec32397225"; // Your Auth Token from www.twilio.com/console

        try {

            $client = new Client($sid, $token);
            $message = $client->messages->create(
             $phone, // Text this number
                [
                'from' => '+19804145549', // From a valid Twilio number
                'body' => 'your verfication number is '.$code,
                ]
         );
  
         return 'sent';

        } catch (\Throwable $th) {
          return $th;
        }
      
        }
    }