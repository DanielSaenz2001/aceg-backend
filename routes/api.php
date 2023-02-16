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
use App\Http\Controllers\Administrativo\CursoController;
use App\Http\Controllers\Administrativo\GestionController;
use App\Http\Controllers\Administrativo\TallerController;
use App\Http\Controllers\Administrativo\HoraController;

use App\Http\Controllers\Matricula\MatriculaController;
use App\Http\Controllers\Matricula\MAlumnoController;
use App\Http\Controllers\Matricula\MHabilitacionCursosController;
use App\Http\Controllers\Matricula\MHabilitacionPlanController;
use App\Http\Controllers\Matricula\MatriculaAlumnoController;
use App\Http\Controllers\Matricula\CulminarMatriculaController;
use App\Http\Controllers\Matricula\MatriculaAdminController;

use App\Http\Controllers\Docente\DCursosController;
use App\Http\Controllers\Docente\DAsistenciaController;
use App\Http\Controllers\Docente\DEvaluacionController;
use App\Http\Controllers\Docente\DNotasController;

use App\Http\Controllers\Alumno\ACursosController;
use App\Http\Controllers\Alumno\APlanController;

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::post('login',                                [AuthController::class, 'login']);
    Route::get('me',                                    [AuthController::class, 'me']);
    Route::post('logout',                               [AuthController::class, 'logout']);
    Route::post('changePassword',                       [AuthController::class, 'cambiarContra']);
    Route::post('sendPasswordResetLink',                [ResetPasswordController::class, 'sendEmail']);
    Route::get('resetPassword/{id}',                    [ChangePasswordController::class, 'process']);
});

Route::prefix('usuario')->group(function ($router) {
    Route::get('',                                      [UserController::class, 'index']);
    Route::get('{id}',                                  [UserController::class, 'show']);
    Route::get('filtro/{p}/{m}/{n}/{d}',                [UserController::class, 'filtro']);
    Route::post('',                                     [UserController::class, 'create']);
    Route::put('{id}',                                  [UserController::class, 'update']);
    Route::delete('{id}',                               [UserController::class, 'destroy']);
    Route::get('estado/{id}',                           [UserController::class, 'estado']);
    Route::put('foto/{id}',                             [UserController::class, 'updateFoto']);
    Route::get('recoveryPa/{id}',                       [UserController::class, 'recoveryPassword']);
    Route::get('addPermiso/{user}/{per}',               [UserController::class, 'addPermiso']);
    Route::get('dltPermiso/{user}/{per}',               [UserController::class, 'deletePermiso']);
});

Route::prefix('links')->group(function ($router) {
    Route::get('',                                      [LinksController::class, 'index']);
    Route::get('{id}',                                  [LinksController::class, 'show']);
    Route::post('',                                     [LinksController::class, 'create']);
    Route::put('{id}',                                  [LinksController::class, 'update']);
    Route::delete('{id}',                               [LinksController::class, 'destroy']);
    Route::get('addPermiso/{link}/{per}',               [LinksController::class, 'addPermiso']);
    Route::get('dltPermiso/{link}/{per}',               [LinksController::class, 'deletePermiso']);
});

Route::prefix('permisos')->group(function ($router) {
    Route::get('',                                      [PermisoController::class, 'index']);
    Route::get('{id}',                                  [PermisoController::class, 'show']);
    Route::post('',                                     [PermisoController::class, 'create']);
    Route::put('{id}',                                  [PermisoController::class, 'update']);
    Route::delete('{id}',                               [PermisoController::class, 'destroy']);
});

Route::prefix('semestres')->group(function ($router) {
    Route::get('',                                      [SemestreController::class, 'index']);
    Route::get('{id}',                                  [SemestreController::class, 'show']);
    Route::post('',                                     [SemestreController::class, 'create']);
    Route::put('{id}',                                  [SemestreController::class, 'update']);
    Route::delete('{id}',                               [SemestreController::class, 'destroy']);
});

Route::prefix('sedes')->group(function ($router) {
    Route::get('',                                      [SedeController::class, 'index']);
    Route::get('{id}',                                  [SedeController::class, 'show']);
    Route::post('',                                     [SedeController::class, 'create']);
    Route::put('{id}',                                  [SedeController::class, 'update']);
    Route::delete('{id}',                               [SedeController::class, 'destroy']);
});

Route::prefix('facultades')->group(function ($router) {
    Route::get('',                                      [FacultadController::class, 'index']);
    Route::get('{id}',                                  [FacultadController::class, 'show']);
    Route::post('',                                     [FacultadController::class, 'create']);
    Route::put('{id}',                                  [FacultadController::class, 'update']);
    Route::delete('{id}',                               [FacultadController::class, 'destroy']);
});

Route::prefix('carreras')->group(function ($router) {
    Route::get('',                                      [CarreraController::class, 'index']);
    Route::get('{id}',                                  [CarreraController::class, 'show']);
    Route::post('',                                     [CarreraController::class, 'create']);
    Route::put('{id}',                                  [CarreraController::class, 'update']);
    Route::delete('{id}',                               [CarreraController::class, 'destroy']);
});

Route::prefix('cursos')->group(function ($router) {
    Route::get('',                                      [CursoController::class, 'index']);
    Route::get('{id}',                                  [CursoController::class, 'show']);
    Route::post('',                                     [CursoController::class, 'create']);
    Route::put('{id}',                                  [CursoController::class, 'update']);
    Route::delete('{id}',                               [CursoController::class, 'destroy']);
});

Route::prefix('talleres')->group(function ($router) {
    Route::get('',                                      [TallerController::class, 'index']);
    Route::get('{id}',                                  [TallerController::class, 'show']);
    Route::post('',                                     [TallerController::class, 'create']);
    Route::put('{id}',                                  [TallerController::class, 'update']);
    Route::delete('{id}',                               [TallerController::class, 'destroy']);
});

Route::prefix('hora')->group(function ($router) {
    Route::get('',                                      [HoraController::class, 'index']);
    Route::get('{id}',                                  [HoraController::class, 'show']);
    Route::post('',                                     [HoraController::class, 'create']);
    Route::put('{id}',                                  [HoraController::class, 'update']);
    Route::delete('{id}',                               [HoraController::class, 'destroy']);
});

Route::prefix('administrativo/gestion')->group(function ($router) {
    Route::get('sedes',                                 [GestionController::class, 'getSedes']);
    Route::get('facultad/{id}',                         [GestionController::class, 'getFacultadesDetailSede']);
    Route::post('facultad',                             [GestionController::class, 'addFacultadesSede']);
    Route::put('facultad/{id}',                         [GestionController::class, 'updateFacultadesSede']);
    Route::delete('facultad/{id}',                      [GestionController::class, 'deleteFacultadesSede']);
    Route::get('carrera/{id}',                          [GestionController::class, 'getCarrerasDetailFacultad']);
    Route::post('carrera',                              [GestionController::class, 'addCarrerasFacultad']);
    Route::put('carrera/{id}',                          [GestionController::class, 'updateCarrerasFacultad']);
    Route::delete('carrera/{id}',                       [GestionController::class, 'deleteCarrerasFacultad']);
    Route::get('planes/{id}',                           [GestionController::class, 'getPlanesDetailCarrera']);
    Route::post('planes',                               [GestionController::class, 'addPlanesCarrera']);
    Route::put('planes/{id}',                           [GestionController::class, 'updatePlanesCarrera']);
    Route::delete('planes/{id}',                        [GestionController::class, 'deletePlanesCarrera']);
    Route::get('periodos/{id}',                         [GestionController::class, 'getPeriodosDetailPlan']);
    Route::post('periodos',                             [GestionController::class, 'addPeriodosplan']);
    Route::put('periodos/{id}',                         [GestionController::class, 'updatePeriodosplan']);
    Route::delete('periodos/{id}',                      [GestionController::class, 'deletePeriodosplan']);
    Route::post('cursos',                               [GestionController::class, 'addCursosDetailPeriodo']);
    Route::put('cursos/{id}',                           [GestionController::class, 'updateCursosDetailPeriodo']);
    Route::delete('cursos/{id}',                        [GestionController::class, 'deleteCursosDetailPeriodo']);
    Route::get('requisitos/{id}',                       [GestionController::class, 'getRequisitosDetailCurso']);
    Route::post('requisitos',                           [GestionController::class, 'addRequisitosDetailCurso']);
    Route::delete('requisitos/{id}',                    [GestionController::class, 'deleteRequisitosDetailCurso']);
});

Route::prefix('matricula/matriculados')->group(function ($router) {
    Route::get('sedes',                                 [MatriculaController::class, 'getSedes']);
    Route::get('facultad/{id}',                         [MatriculaController::class, 'getFacultades']);
    Route::get('carrera/{id}',                          [MatriculaController::class, 'getCarreras']);
    Route::get('planes/{id}',                           [MatriculaController::class, 'getPlanes']);
    Route::get('search/{plan_id}/{anhio_id}',           [MatriculaController::class, 'search']);
});

Route::prefix('matricula/alumno')->group(function ($router) {
    Route::get('filtro/{p}/{m}/{n}/{d}',                [MAlumnoController::class, 'filtro']);
    Route::get('plan/{alumno_id}',                      [MAlumnoController::class, 'getPlanesAlumno']);
    Route::get('plan/facultad/{id}',                    [MAlumnoController::class, 'getFacultades']);
    Route::get('plan/carrera/{id}',                     [MAlumnoController::class, 'getCarreras']);
    Route::get('plan/planes/{id}',                      [MAlumnoController::class, 'getPlanes']);
    Route::get('plan/periodos/{id}',                    [MAlumnoController::class, 'getPeriodos']);
    Route::get('plan/requisitos/{id}',                  [MAlumnoController::class, 'getRequisitos']);
    
    Route::post('plan',                                 [MAlumnoController::class, 'savePlanAlumno']);
});

Route::prefix('matricula/habilitacion')->group(function ($router) {
    Route::get('sedes/get',                             [MHabilitacionCursosController::class, 'getSedes']);
    Route::get('facultad/{id}',                         [MHabilitacionCursosController::class, 'getFacultades']);
    Route::get('carrera/{id}',                          [MHabilitacionCursosController::class, 'getCarreras']);
    Route::get('planes/{id}',                           [MHabilitacionCursosController::class, 'getPlanes']);
    Route::get('periodos/{id}/{semestre_id}',           [MHabilitacionCursosController::class, 'getPeriodos']);

    Route::post('{plan_id}',                            [MHabilitacionCursosController::class, 'create']);
    Route::put('{id}/{plan_id}',                        [MHabilitacionCursosController::class, 'update']);
    Route::get('{id}',                                  [MHabilitacionCursosController::class, 'getById']);
    Route::delete('{id}/{plan_id}/{semestre_id}',       [MHabilitacionCursosController::class, 'destroy']);

    Route::get('docente/{id}/{curso_id}',               [MHabilitacionCursosController::class, 'changeDocente']);
});

Route::prefix('matricula/planes')->group(function ($router) {
    Route::get('sedes/get',                             [MHabilitacionPlanController::class, 'getSedes']);
    Route::get('facultad/{id}',                         [MHabilitacionPlanController::class, 'getFacultades']);
    Route::get('carrera/{id}',                          [MHabilitacionPlanController::class, 'getCarreras']);
    Route::get('planes/{id}/{semestre_id}',             [MHabilitacionPlanController::class, 'getPlanes']);

    Route::post('{carrera_id}',                         [MHabilitacionPlanController::class, 'create']);
    Route::delete('{id}/{carrera_id}',                  [MHabilitacionPlanController::class, 'destroy']);
});

Route::prefix('matricula/alumno')->group(function ($router) {
    Route::get('',                                      [MatriculaAlumnoController::class, 'index']);
    Route::get('paso2/{id}',                            [MatriculaAlumnoController::class, 'getPaso2ById']);
    Route::post('',                                     [MatriculaAlumnoController::class, 'create']);
    Route::post('paso2',                                [MatriculaAlumnoController::class, 'matriculaPaso2']);
    Route::put('paso2',                                 [MatriculaAlumnoController::class, 'updatematriculaPaso2']);
});

Route::prefix('matricula/culminar')->group(function ($router) {
    Route::get('sedes/get',                             [CulminarMatriculaController::class, 'getSedes']);
    Route::get('facultad/{id}',                         [CulminarMatriculaController::class, 'getFacultades']);
    Route::get('carrera/{id}',                          [CulminarMatriculaController::class, 'getCarreras']);
    Route::get('planes/{id}',                           [CulminarMatriculaController::class, 'getPlanes']);
    Route::get('matriculados/{semestre_id}/{plan_id}',  [CulminarMatriculaController::class, 'getMatriculados']);

    
    Route::get('{id}',                                  [CulminarMatriculaController::class, 'getById']);
    Route::get('paso3/{id}',                            [CulminarMatriculaController::class, 'paso3']);
});

Route::prefix('matricula/admin')->group(function ($router) {
    Route::post('',                                     [MatriculaAdminController::class, 'create']);
});

Route::prefix('docente')->group(function ($router) {
    Route::get('',                                      [DCursosController::class, 'getCursos']);
    Route::get('alumnos/{id}',                          [DCursosController::class, 'getAlumnos']);

    Route::get('asistencia/{id}/{date}',                [DAsistenciaController::class, 'getAlumnos']);
    Route::post('asistencia',                           [DAsistenciaController::class, 'create']);

    Route::get('evaluacion/{id}',                       [DEvaluacionController::class, 'getEvaluaciones']);
    Route::get('evaluacion/detail/{id}',                [DEvaluacionController::class, 'getById']);
    Route::post('evaluacion',                           [DEvaluacionController::class, 'create']);
    Route::put('evaluacion/{id}',                       [DEvaluacionController::class, 'update']);
    Route::delete('evaluacion/{id}',                    [DEvaluacionController::class, 'destroyEvaluaciones']);

    Route::get('notas/{cur_id}/{evl_id}',               [DNotasController::class, 'getAlumnos']);
    Route::post('notas',                                [DNotasController::class, 'create']);

    Route::get('upnotas/{cur_id}',                      [DEvaluacionController::class, 'upNotas']);
});

Route::prefix('alumno')->group(function ($router) {
    Route::get('',                                      [ACursosController::class, 'getCursos']);
    Route::get('{id}',                                  [ACursosController::class, 'getCursosByOtherMatricula']);
    Route::get('evaluacion/{id}',                       [ACursosController::class, 'getEvaluaciones']);
    Route::get('asistencia/{id}',                       [ACursosController::class, 'getAsistencia']);

    Route::get('/get/planes',                           [APlanController::class, 'getPlanes']);
    Route::get('/get/planes/{id}',                      [APlanController::class, 'getPlanesByPlan']);
    Route::get('/get/planes/requisitos/{id}',           [APlanController::class, 'getRequisitos']);
});
