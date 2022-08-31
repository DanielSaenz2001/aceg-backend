<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;

use App\Http\Controllers\Admin\UserController;

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

Route::prefix('usuario')->group(function ($router) {
    Route::get('',                  [UserController::class, 'index']);
    Route::get('{id}',              [UserController::class, 'show']);
    Route::post('filtro',           [UserController::class, 'filtro']);
    Route::post('',                 [UserController::class, 'create']);
    Route::put('{id}',              [UserController::class, 'update']);
    Route::delete('{id}',           [UserController::class, 'destroy']);
    Route::get('estado/{id}',       [UserController::class, 'estado']);
    Route::put('foto/{id}',         [UserController::class, 'updateFoto']);
    Route::get('recoveryPa/{id}',   [UserController::class, 'recoveryPassword']);
});