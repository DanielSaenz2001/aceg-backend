<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LinksController;
use App\Http\Controllers\Admin\PermisoController;

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
    Route::get('',                          [UserController::class, 'index']);
    Route::get('{id}',                      [UserController::class, 'show']);
    Route::post('filtro',                   [UserController::class, 'filtro']);
    Route::post('',                         [UserController::class, 'create']);
    Route::put('{id}',                      [UserController::class, 'update']);
    Route::delete('{id}',                   [UserController::class, 'destroy']);
    Route::get('estado/{id}',               [UserController::class, 'estado']);
    Route::put('foto/{id}',                 [UserController::class, 'updateFoto']);
    Route::get('recoveryPa/{id}',           [UserController::class, 'recoveryPassword']);
    Route::get('addPermiso/{user}/{per}',   [UserController::class, 'addPermiso']);
    Route::get('dltPermiso/{user}/{per}',   [UserController::class, 'deletePermiso']);
});

Route::prefix('links')->group(function ($router) {
    Route::get('',                          [LinksController::class, 'index']);
    Route::get('{id}',                      [LinksController::class, 'show']);
    Route::post('',                         [LinksController::class, 'create']);
    Route::put('{id}',                      [LinksController::class, 'update']);
    Route::delete('{id}',                   [LinksController::class, 'destroy']);
    Route::get('addPermiso/{link}/{per}',   [LinksController::class, 'addPermiso']);
    Route::get('dltPermiso/{link}/{per}',   [LinksController::class, 'deletePermiso']);
});

Route::prefix('permisos')->group(function ($router) {
    Route::get('',                  [PermisoController::class, 'index']);
    Route::get('{id}',              [PermisoController::class, 'show']);
    Route::post('',                 [PermisoController::class, 'create']);
    Route::put('{id}',              [PermisoController::class, 'update']);
    Route::delete('{id}',           [PermisoController::class, 'destroy']);
});