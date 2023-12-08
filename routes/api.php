<?php

use App\Http\Controllers\Api\AuthenticateController;
use App\Http\Controllers\Api\UserController;
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

Route::post('auth/users', AuthenticateController::class)
    ->name('api.auth.users');

Route::get('users/pdf', [UserController::class, 'getUrlPdf'])
    ->name('api.users.pdf');

Route::resource('users', UserController::class)
    ->middleware('auth:sanctum')
    ->names('api.users');
