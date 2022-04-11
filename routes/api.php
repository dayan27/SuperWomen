<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentWriterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RoleModelController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

  //====================authenticated route
  Route::middleware(['auth:sanctum'])->group(function () {
    // Route::post('/send_verification',[EmailVerificationController::class,'sendVerificationEmail'])->name('verification.send');
        //Route::post('/resend',[EmailVerificationController::class,'resend']);
        Route::post('/logout',[LoginController::class,'logout']);
        Route::post('/change_password',[LoginController::class,'changePassword']);


        //-------start role_model related---------

        Route::apiResource('/role_models',RoleModelController::class);

        Route::delete('/delete_image/{id}',[RoleModelController::class,'deleteImage']);
        Route::post('/update_images',[RoleModelController::class,'updateImage']);
       //-------end role_model related---------------

        //blog  related

        Route::apiResource('/blogs',BlogController::class);
        Route::delete('/delete_blog_image/{id}',[BlogController::class,'deleteImage']);
        Route::post('/update_blog_images',[BlogController::class,'updateImage']);

        // end blog related
        Route::apiResource('/users',UserController::class);
    });
    //=================== end auth route  ========


            ///////////////======verification and forgot password
            Route::get('/verify',[EmailVerificationController::class,'verify'])->name('verification.verify');
            //  ->middleware('signed');
            Route::post('/login',[LoginController::class,'login'])->middleware('verified');
            Route::post('/forgot',[ForgotPasswordController::class,'forgot']);
            Route::post('/reset/{token}',[ResetPasswordController::class,'resetPassword']);


Route::apiResource('/users',UserController::class);
Route::apiResource('/contacts',ContactController::class);
Route::apiResource('/fields',FieldController::class);
Route::apiResource('/mentors',MentorController::class);
Route::apiResource('/tags',TagController::class);

    Route::apiResource('/employees',EmployeeController::class);

Route::apiResource('/partners',PartnerController::class);



