<?php

       /////////User Side Routes
                  //.....User Account related

use App\Http\Controllers\UserAccount\UserForgotPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserAccount\SubscriptionEmailController;
use App\Http\Controllers\UserAccount\UserLoginController;
use App\Http\Controllers\UserAccount\UserRegistrationController;
use App\Http\Controllers\UserAccount\UserVerificationController;
use App\Http\Controllers\UserSide\ChattingController;
use App\Models\EducationLevel;
use Illuminate\Support\Facades\Route;



  

    Route::post('/register', [UserRegistrationController::class, 'registerUser']);
    Route::post('/verify_phone', [UserVerificationController::class, 'verifyPhone']);
    Route::post('/resend',[UserLoginController::class,'resend']);
    Route::post('/login',[UserLoginController ::class,'login']);
  
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout',[UserLoginController::class,'logout']);
        Route::post('/set_interest', [UserRegistrationController::class, 'addUserInterest']);
        Route::post('/update_profile', [UserRegistrationController::class, 'updateProfile']);
        Route::post('/change_phone',[UserLoginController ::class,'changePhoneNumber']);
        Route::post('/send_message',[ChattingController ::class,'sendMessage']);
        Route::get('/messages',[ChattingController ::class,'getMessages']);
});

    ////////========below routes are not imp't here because of otp====///
    // Route::post('/forgot',[UserForgotPasswordController::class,'forgot']);
    // Route::post('/verify_reset/{token}', [UserForgotPasswordController::class, 'verifyResetOtp']);
    // Route::post('/reset/{token}',[UserForgotPasswordController::class,'resetPassword']);

    Route::post('/subscribe', [SubscriptionEmailController::class, 'subscribe_email']);


    Route::get('/education_levels', function () {
        //return Hash::make('12345678');
        //$data='helloplease work  hard';
        return EducationLevel::all(['id','level']);
    });