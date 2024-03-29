<?php

use App\Events\AdminNotification;
use App\Events\MessagePublished;
use App\Models\Message;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return Hash::make('12345678');
    //$data='helloplease work  hard';
    return event(new MessagePublished('hello'));
  //  return event(new AdminNotification());
    return 'sent';
});

Route::fallback(function ()
{
    # To Specific Controller
   //.. return Redirect::to('homeController'); # ('/') if defined 

    # To Specific View
    return response()->json('Invalide url', 404);
});