<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LinksController;
use App\Http\Controllers\Admin\PermisoController;

use App\Http\Controllers\Administrativo\SemestreController;
use App\Http\Controllers\Administrativo\SedeController;
use App\Http\Controllers\Administrativo\FacultadController;
use App\Http\Controllers\Administrativo\CarreraController;
use App\Http\Controllers\Administrativo\GestionController;

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
    Route::get('filtro/{p}/{m}/{n}/{d}',    [UserController::class, 'filtro']);
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

Route::prefix('semestres')->group(function ($router) {
    Route::get('',                  [SemestreController::class, 'index']);
    Route::get('{id}',              [SemestreController::class, 'show']);
    Route::post('',                 [SemestreController::class, 'create']);
    Route::put('{id}',              [SemestreController::class, 'update']);
    Route::delete('{id}',           [SemestreController::class, 'destroy']);
});

Route::prefix('sedes')->group(function ($router) {
    Route::get('',                  [SedeController::class, 'index']);
    Route::get('{id}',              [SedeController::class, 'show']);
    Route::post('',                 [SedeController::class, 'create']);
    Route::put('{id}',              [SedeController::class, 'update']);
    Route::delete('{id}',           [SedeController::class, 'destroy']);
});

Route::prefix('facultades')->group(function ($router) {
    Route::get('',                  [FacultadController::class, 'index']);
    Route::get('{id}',              [FacultadController::class, 'show']);
    Route::post('',                 [FacultadController::class, 'create']);
    Route::put('{id}',              [FacultadController::class, 'update']);
    Route::delete('{id}',           [FacultadController::class, 'destroy']);
});

Route::prefix('carreras')->group(function ($router) {
    Route::get('',                  [CarreraController::class, 'index']);
    Route::get('{id}',              [CarreraController::class, 'show']);
    Route::post('',                 [CarreraController::class, 'create']);
    Route::put('{id}',              [CarreraController::class, 'update']);
    Route::delete('{id}',           [CarreraController::class, 'destroy']);
});

Route::prefix('administrativo/gestion')->group(function ($router) {
    Route::get('sedes',             [GestionController::class, 'index']);
});

