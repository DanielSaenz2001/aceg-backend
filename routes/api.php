<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::post('login',                    [AuthController::class, 'login']);
    Route::get('me',                        [AuthController::class, 'me']);
    Route::post('logout',                   [AuthController::class, 'logout']);
    Route::post('changePassword',           [AuthController::class, 'cambiarContra']);
    Route::post('sendPasswordResetLink',    [ResetPasswordController::class, 'sendEmail']);
    Route::get('resetPassword/{id}',        [ChangePasswordController::class, 'process']);
});