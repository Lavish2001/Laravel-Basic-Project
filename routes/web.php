<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\UserAuth;
use App\Http\Middleware\UserLog;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// WELCOME PAGE //
Route::get('/home', function () {
    return view('welcome');
});


//-----User Routes-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------//


// USER SIGNUP //
Route::post('/signup',[UserController::class,'signup'])->middleware(UserLog::class);


// USER LOGIN //
Route::post('/login',[UserController::class,'login'])->middleware(UserLog::class);


// USER LOGOUT //
Route::post('/logout',[UserController::class,'logout'])->middleware(UserAuth::class);


// USER CHANGE PASSWORD //
Route::patch('/change_password',[UserController::class,'ChangePassword'])->middleware(UserAuth::class);


// USER DEACTIVATE ACCOUNT //
Route::delete('/deactivate_account',[UserController::class,'DeactivateAccount'])->middleware(UserAuth::class);




//----Post Routes-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------//



// USER UPLOAD POST //
Route::post('/upload',[PostController::class,'upload'])->middleware(UserAuth::class);


// USER DELETE POST //
Route::delete('/delete',[PostController::class,'delete'])->middleware(UserAuth::class);


// USER LIVE POST //
Route::get('/Images/{name}',[PostController::class,'live']);


// COMMENT ON POST //
Route::post('/comment',[PostController::class,'comment'])->middleware(UserAuth::class);


// USER ALL DETAILS USING RELATIONS //
Route::get('/all',[PostController::class,'all'])->middleware(UserAuth::class);








