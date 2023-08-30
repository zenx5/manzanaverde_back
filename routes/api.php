<?php

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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

Route::post('/user/login', function (Request $request) {
    
    $email = $request->input('email');
    $password = $request->input('password');
    $hashedPassword = Hash::make($password);


    return $hashedPassword;
});

Route::post('/user/register', function (Request $request) {
    return $_POST;
});


Route::resource('foods', App\Http\Controllers\API\FoodAPIController::class)
    ->except(['create', 'edit']);