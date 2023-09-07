<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//User CRUD routes
Route::post('/createNewUser',[UserController::class,'createNewUser']);
Route::get('/readOneUser', [UserController::class,'readOneUser']);
Route::get('/readAllUsers', [UserController::class,'readAllUsers']);
Route::put('/updateUser', [UserController::class,'updateUser']);
Route::delete('/deleteUser', [UserController::class,'deleteUser']);
Route::get('/searchUsers', [UserController::class, 'searchUsers']);

//Auth Controller routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
//Auth saunctum routes
Route::group(['middleware'=> ['auth:sanctum']], function(){    
Route::post('/logout',[AuthController::class,'logout']);
    });

