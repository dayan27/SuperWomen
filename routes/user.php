<?php
     /////////User Side Routes
                  //.....User Account related

use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\UserAccount\UserForgotPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserAccount\AccountController;
use App\Http\Controllers\UserAccount\SubscriptionEmailController;
use App\Http\Controllers\UserAccount\UserLoginController;
use App\Http\Controllers\UserAccount\UserRegistrationController;
use App\Http\Controllers\UserAccount\UserVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSide\BlogController as UserSideBlogController;
use App\Http\Controllers\UserSide\ChattingController;
use App\Http\Controllers\UserSide\MentorControler;
use App\Http\Controllers\UserSide\RequestController;
use App\Http\Controllers\UserSide\RoleModelController;
use App\Http\Resources\User\BlogResource;
use App\Models\EducationLevel;
use App\Models\Mentor;
use Illuminate\Support\Facades\Route;



  

    Route::post('/register', [UserRegistrationController::class, 'registerUser']);
    Route::post('/verify_phone', [UserVerificationController::class, 'verifyPhone']);
    Route::post('/resend',[UserVerificationController::class,'resend']);
    Route::post('/login',[UserLoginController ::class,'login']);
  
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/user',[UserLoginController::class,'getLoginUser']);
        Route::post('/logout',[UserLoginController::class,'logout']);
        Route::post('/set_interest', [UserRegistrationController::class, 'addUserInterest']);
        Route::post('/update_profile', [UserRegistrationController::class, 'updateProfile']);
        Route::post('/change_phone',[UserLoginController ::class,'changePhoneNumber']);
        Route::post('/send_message',[ChattingController ::class,'sendMessage']);
        Route::get('/messages',[ChattingController ::class,'getMessages']);
        Route::delete('/message/{id}',[ChattingController ::class,'deleteMessage']);
        Route::put('/message/{id}',[ChattingController ::class,'editMessage']);
        

    
        Route::get('/disconnect_mentor',[AccountController ::class,'DisconnectMentor']);

        Route::get('/my_mentor',[AccountController ::class,'myMentor']);
        Route::get('/my_interests',[AccountController ::class,'myInterests']);
       
        Route::get('/my_requests',[RequestController ::class,'myRequests']);
        Route::post('/send_mentor_request/{mentor_id}',[RequestController ::class,'sendRequest']);
        Route::post('/change_profile_picture',[UserRegistrationController::class,'changeProfilePicture']);


        Route::post('/add_comment/{id}', [RoleModelController::class, 'addComment']);
        Route::post('/add_like/{id}', [RoleModelController::class, 'addLike']); 
       
        Route::post('/add_blog_comment/{id}', [UserSideBlogController::class, 'addComment']);
        Route::post('/add_blog_like/{id}', [UserSideBlogController::class, 'addLike']);
});

Route::get('/mentors',[MentorControler ::class,'getMentors']);

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


    //Dayan user's side
    Route::get('/get_blogs', [UserSideBlogController::class, 'getBlogs']);
    Route::get('/get_recent_blogs', [UserSideBlogController::class, 'getRecentBlogs']);
    Route::get('/get_detail_blogs/{id}', [UserSideBlogController::class, 'getBlogDetail']);   

    Route::get('/get_recent_role_models', [RoleModelController::class, 'getRecentRoleModels']);
    Route::get('/get_role_models', [RoleModelController::class, 'getRoleModels']);
    Route::get('/get_detail_role_models/{id}', [RoleModelController::class, 'getRoleModelDetail']);   
    Route::get('/get_related_role_models/{id}', [RoleModelController::class, 'getRelatedRoleModels']);   
    Route::get('/get_detail_blog/{id}', [UserSideBlogController::class, 'getBlogDetail']);   
    Route::get('/get_related_blogs/{id}', [UserSideBlogController::class, 'getRelatedBlog']);   

     Route::fallback(function ()
{
    # To Specific Controller
   //.. return Redirect::to('homeController'); # ('/') if defined 

    # To Specific View
    return response()->json('Invalide url', 404);
});