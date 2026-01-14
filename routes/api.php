<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\HeroContentController;
use App\Http\Controllers\Api\ContractFormControllers;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource('category', CategoryController::class);
Route::get('/categories/status', [CategoryController::class, 'getByStatus']);

Route::post('/blogs', [BlogController::class, 'store']);
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('blogs/category/{id}', [BlogController::class, 'getByCategory']);
Route::get('blogs/{id}', [BlogController::class, 'getBlogDetails']);
Route::post('blogs/update/{id}', [BlogController::class, 'update']);
Route::delete('blogs/{id}', [BlogController::class, 'destroy']);


Route::post('/hero-content', [HeroContentController::class, 'store']);
Route::get('/hero-content', [HeroContentController::class, 'index']);
Route::delete('/hero-content/{id}', [HeroContentController::class, 'destroy']);
Route::put('/hero-content/{id}', [HeroContentController::class, 'update']);
Route::get('/hero-content/{id}', [HeroContentController::class, 'getById']);

Route::post('/contract-from', [ContractFormControllers::class, 'store']);
Route::get('/contract-from', [ContractFormControllers::class, 'index']);



Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::post('/send-otp',[AuthController::class,'sendOtp']);
Route::post('/verify-otp',[AuthController::class,'verifyOtp']);
Route::post('/reset-password',[AuthController::class,'resetPassword']);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
});
