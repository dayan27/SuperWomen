<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogTranslationController;
use App\Http\Controllers\Admin\LanguageController as AdminLanguageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleModelController;
use App\Http\Controllers\Admin\RoleModelTranslationController as AdminRoleModelTranslationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentWriterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RoleModelTranslationController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSide\RoleModelController as UserSideRoleModelController;
use App\Models\RoleModelTranslation;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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
        Route::post('/change_profile/{id}',[EmployeeController::class,'changeProfilePicture']);

        Route::get('/mark_all_as_read',[NotificationController::class,'markAllAsRead']);
        Route::get('/mark_all_as_seen',[NotificationController::class,'markAllAsSeen']);
        Route::get('/mark_as_read/{id}',[NotificationController::class,'markOneAsRead']);
        
        Route::get('/admin_notifications',function(Request $request){
            // foreach($request->user()->notifications as $not){

            //     if($not->type=='App\Notifications\toAdmin\BlogAdded'){
            //        $blog[]=$not;
            //     }else if($not->type=='App\Notifications\toAdmin\RoleModelAdded'){
            //         $role[]=$not;

            //     }else if($not->type=='App\Notifications\NewNotification'){
            //         $mentor[]=$not;

            //     }
        //    }


           // return ['blog'=>$blog,'rolemodel'=>$role,'mentor'=>$mentor];

           //return Employee::find(1)->notifications;
          return $request->user()->notifications;
        });


        //-------start role_model related---------

        Route::apiResource('/role_model_translations',AdminRoleModelTranslationController::class);


        //-------end role_model related---------------

        //blog  related
        Route::apiResource('/blogs',BlogController::class);
        Route::apiResource('/blog_translations',BlogTranslationController::class);

    Route::apiResource('/role_models',RoleModelController::class);


        // end blog related
       // Route::apiResource('/users',UserController::class);
    });


    //=================== end auth route  ========

    Route::post('/content_image',[RoleModelController::class,'contentImageUpload']);
    Route::get('/summary',[RoleModelController::class,'getTotalData']);
    Route::post('/rm_verify/{id}',[RoleModelController::class,'verify']);

    Route::delete('/delete_image/{id}',[RoleModelController::class,'deleteImage']);
    Route::post('/update_images/{id}',[RoleModelController::class,'updateImage']);
    Route::post('/update_audio/{id}',[RoleModelController::class,'updateAudio']);
    Route::post('/update_card_image/{id}',[RoleModelController::class,'updateCardImage']);

    //Route::get('/dashboard',[DashboardController::class,'getData']);

    ////
    Route::post('/blog_content_image',[BlogController::class,'contentImageUpload']);
    Route::get('/blog_summary',[BlogController::class,'getTotalData']);
    Route::post('/blog_verify/{id}',[BlogController::class,'verify']);

    Route::delete('/delete_blog_image/{id}',[BlogController::class,'deleteImage']);
    Route::post('/update_blog_images/{id}',[BlogController::class,'updateImage']);

            ///////////////======verification and forgot password
            Route::get('/verify',[EmailVerificationController::class,'verify'])->name('verification.verify');
            //  ->middleware('signed');
            Route::post('/login',[LoginController ::class,'login']);
            //->middleware('verified');
            Route::post('/forgot',[ForgotPasswordController::class,'forgot']);
            Route::post('/reset/{token}',[ResetPasswordController::class,'resetPassword']);

            Route::get('/dash_board',[DashboardController::class,'getData']);

            Route::apiResource('/users',UserController::class);
            Route::post('/block_user/{id}',[UserController::class,'changeUserState']);


            Route::apiResource('/contacts',ContactController::class);
            Route::apiResource('/fields',FieldController::class);
            Route::apiResource('/mentors',MentorController::class);
            Route::get('/mentor_requests',[MentorController::class,'getMentorRequests']);
            Route::post('/accept_mentor_request/{id}',[MentorController::class,'acceptMentorRequest']);
            Route::post('/change_mentor_status/{id}',[MentorController::class,'changeMentorStatus']);

            Route::apiResource('/tags',TagController::class);

            Route::apiResource('/employees',EmployeeController::class);

           // Route::apiResource('/partners',PartnerController::class);



            Route::get('/user_role_models',[UserSideRoleModelController::class,'getRoleModels']);
            Route::get('/user_home_role_models',[UserSideRoleModelController::class,'getRecentRoleModels']);
  

            //admn dayan
            Route::apiResource('/languages',AdminLanguageController::class);
            Route::get('/search_role_models',[RoleModelController::class,'search']);
            Route::get('/search_blogs',[BlogController::class,'search']);
            Route::apiResource('/permissions',PermissionController::class);
            Route::apiResource('/roles',RoleController::class);
            Route::post('/assign_permission/{id}',[RoleController::class,'assignPermissions']);
            Route::post('/assign_role/{id}',[EmployeeController::class,'assignRoleToEmployee']);

         /////////User Side Routes
                  //.....User Account related
                  // Route::post('/verify_otp', [UserLoginController::class, 'verifyPhone']);
                  // Route::post('/verify_reset_otp/{token}', [UserLoginController::class, 'checkResetOtp']);
               //   Route::post('/subscribe', [SubscriptionEmailController::class, 'subscribe_email']);

               Broadcast::routes(['middleware' => ['auth:sanctum']]);