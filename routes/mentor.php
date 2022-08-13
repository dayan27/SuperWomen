<?php

use App\Events\AdminNotification;
use App\Http\Controllers\MentorAccount\AccountController;
use App\Http\Controllers\MentorAccount\MentorLoginController;
use App\Http\Controllers\MentorAccount\MentorRegistrationController;
use App\Http\Controllers\MentorAccount\MentorVerificationController;
use App\Http\Controllers\MentorSide\AvailabilityController;
use App\Http\Controllers\MentorSide\ChattingController;
use App\Http\Controllers\MentorSide\ExperianceController;
use App\Http\Controllers\MentorSide\RequestController;
use App\Models\EducationLevel;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Route;




    Route::post('/register', [MentorRegistrationController::class, 'register']);
    Route::post('/verify_phone', [MentorVerificationController::class, 'verifyPhone']);
    Route::post('/resend',[MentorVerificationController::class,'resend']);
    Route::post('/login',[MentorLoginController::class,'login']);
  

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/mentor', function () {
            //return Hash::make('12345678');
            //$data='helloplease work  hard';
            $user=request()->user();
            $user->profile_picture= $user->profile_picture ? asset('/profilepictures').'/'.$user->profile_picture :null;
        
            return $user;
        });

        
        Route::post('/logout',[MentorLoginController::class,'logout']);
       // Route::post('/set_experiance', [MentorRegistrationController::class, 'addMentorExperiance']);
        Route::post('/update_profile', [MentorRegistrationController::class, 'updateProfile']);
        Route::post('/change_phone',[MentorLoginController ::class,'changePhoneNumber']);
        Route::post('/send_message',[ChattingController ::class,'sendMessage']);
        Route::get('/messages/{user_id}',[ChattingController ::class,'getMessages']);

        Route::apiResource('/availabilities',AvailabilityController::class);
        Route::apiResource('/experiances',ExperianceController::class);


        Route::get('/my_mentees',[AccountController ::class,'myMentees']);
        Route::get('/chat_mentees',[ChattingController ::class,'getChates']);
       
        Route::get('/mentee_requests',[RequestController ::class,'userRequests']);
        Route::post('/accept_request/{req_id}',[RequestController ::class,'acceptRequest']);
        Route::post('/reject_request/{req_id}',[RequestController ::class,'rejectRequest']);
        
});

    Route::post('/forgot',[UserForgotPasswordController::class,'forgot']);
    Route::post('/verify_reset/{token}', [UserForgotPasswordController::class, 'verifyResetOtp']);
    Route::post('/reset/{token}',[UserForgotPasswordController::class,'resetPassword']);


