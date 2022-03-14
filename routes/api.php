<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentWriterController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RoleModelController;
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
Route::apiResource('/users',UserController::class);
Route::apiResource('/contacts',ContactController::class);
Route::apiResource('/fields',FieldController::class);
Route::apiResource('/mentors',MentorController::class);
Route::apiResource('/blogs',BlogController::class);
Route::apiResource('/content_writers',ContentWriterController::class);
Route::apiResource('/role_models',RoleModelController::class);

Route::apiResource('/partners',PartnerController::class);



