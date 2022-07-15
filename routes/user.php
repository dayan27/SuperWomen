<?php

       /////////User Side Routes
                  //.....User Account related

use App\Http\Controllers\Auth\UserForgotPasswordController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\UserAccount\UserRegistrationController;
use App\Http\Controllers\UserAccount\UserVerificationController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {
    // Route::post('/send_verification',[EmailVerificationController::class,'sendVerificationEmail'])->name('verification.send');
        //Route::post('/resend',[EmailVerificationController::class,'resend']);
        Route::post('/logout',[LoginController::class,'logout']);

});
    Route::post('/register', [UserRegistrationController::class, 'registerUser']);
    Route::post('/set_interest/{user_id}', [UserRegistrationController::class, 'addUserInterest']);
    Route::post('/verify_phone', [UserVerificationController::class, 'verifyPhone']);
    Route::post('/resend',[UserLoginController::class,'resend']);
    Route::post('/user_login',[UserLoginController ::class,'login']);


    Route::post('/forgot',[UserForgotPasswordController::class,'forgot']);
    Route::post('/verify_reset/{token}', [UserForgotPasswordController::class, 'verifyResetOtp']);
    Route::post('/reset/{token}',[UserForgotPasswordController::class,'resetPassword']);

    Route::post('/subscribe', [SubscriptionEmailController::class, 'subscribe_email']);
