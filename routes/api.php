<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentWriterController;
use App\Http\Controllers\DashboardControler;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RoleModelController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSide\RoleModelController as UserSideRoleModelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

//====================authenticated route
  Route::middleware(['auth:sanctum'])->group(function () {
    // Route::post('/send_verification',[EmailVerificationController::class,'sendVerificationEmail'])->name('verification.send');
        //Route::post('/resend',[EmailVerificationController::class,'resend']);
        Route::post('/logout',[LoginController::class,'logout']);
        Route::post('/change_password',[LoginController::class,'changePassword']);


        //-------start role_model related---------


     
        //-------end role_model related---------------

        //blog  related

   
        // end blog related
       // Route::apiResource('/users',UserController::class);
    });
    //=================== end auth route  ========

    Route::apiResource('/role_models',RoleModelController::class);
    Route::post('/content_image',[RoleModelController::class,'contentImageUpload']);
    Route::get('/summary',[RoleModelController::class,'getTotalData']);
    Route::post('/rm_verify/{id}',[RoleModelController::class,'verify']);
    Route::delete('/delete_image/{id}',[RoleModelController::class,'deleteImage']);
    Route::post('/update_images/{id}',[RoleModelController::class,'updateImage']);

    Route::get('/dashboard',[DashboardControler::class,'getData']);

    ////
    Route::apiResource('/blogs',BlogController::class);
    Route::post('/blog_content_image',[BlogController::class,'contentImageUpload']);
    Route::get('/blog_summary',[BlogController::class,'getTotalData']);
    Route::post('/blog_verify/{id}',[BlogController::class,'verify']);
    
    Route::delete('/delete_blog_image/{id}',[BlogController::class,'deleteImage']);
    Route::post('/update_blog_images/{id}',[BlogController::class,'updateImage']);

            ///////////////======verification and forgot password
            Route::get('/verify',[EmailVerificationController::class,'verify'])->name('verification.verify');
            //  ->middleware('signed');
            Route::post('/login',[LoginController::class,'login'])->middleware('verified');
            Route::post('/forgot',[ForgotPasswordController::class,'forgot']);
            Route::post('/reset/{token}',[ResetPasswordController::class,'resetPassword']);


            Route::apiResource('/users',UserController::class);
            Route::post('/block_user/{id}',[UserController::class,'changeUserState']);

            
            Route::apiResource('/contacts',ContactController::class);
            Route::apiResource('/fields',FieldController::class);
            Route::apiResource('/mentors',MentorController::class);
            Route::get('/mentor_requests',[MentorController::class,'getMentorRquests']);

            Route::apiResource('/tags',TagController::class);

            Route::apiResource('/employees',EmployeeController::class);

            Route::apiResource('/partners',PartnerController::class);



            Route::get('/user_role_models',[UserSideRoleModelController::class,'getRoleModels']);
            Route::get('/user_home_role_models',[UserSideRoleModelController::class,'getRecentRoleModels']);
