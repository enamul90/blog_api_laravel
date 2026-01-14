<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [FrontendController::class, 'home'])->name('frontend');