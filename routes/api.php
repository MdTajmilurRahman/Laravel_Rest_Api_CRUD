<?php

use App\Http\Controllers\api\Usercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('users',[Usercontroller::class, 'index']);
Route::Post('user/add',[Usercontroller::class, 'store']);
Route::get('user/{id}',[Usercontroller::class, 'show']);
Route::put('user/update/{id}',[Usercontroller::class, 'update']);
Route::delete('user/delete/{id}',[Usercontroller::class, 'destroy']);




