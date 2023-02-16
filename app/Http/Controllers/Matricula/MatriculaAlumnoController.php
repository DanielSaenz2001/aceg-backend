<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\PlanAlumno;
use App\Models\Administrativo\PlanRequisito;
use App\Models\Administrativo\PlanAlumnoNota;
use App\Models\Matricula\Matricula;
use App\Models\Matricula\SemestresCurso;
use App\Models\Matricula\SemestresCursosAlumno;
use App\Models\User;
use Carbon\Carbon;
use Response;

class MatriculaAlumnoController extends Controller
{
    public function index(){
        $data = [];
        $planes = PlanAlumno::join('plan_academico', 'plan_academico.id', 'plan_alumnos.plan_academico_id')
        ->join('semestres_planes', 'semestres_planes.plan_academico_id', 'plan_academico.id')
        ->join('semestres', 'semestres.id', 'semestres_planes.semestre_id')
        ->join('facultades_carreras', 'facultades_carreras.id', 'plan_academico.facultad_carrera_id')
        ->join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
        ->join('facultades', 'facultades.id', 'carreras.facultad_id')
        ->join('sedes_facultades', 'sedes_facultades.id', 'facultades_carreras.sede_facultad_id')
        ->join('sedes', 'sedes.id', 'sedes_facultades.sede_id')
        ->where('plan_alumnos.estado', true)
        ->where('semestres.estado', true)
        ->where('plan_alumnos.alumno_id', auth()->user()->id)
        ->select('semestres.nombre as semestre', 'carreras.nombre as carrera'
        , 'facultades.nombre as facultad', 'sedes.matricula', 'sedes.nombre as sede'
        , 'sedes.direccion', 'semestres_planes.semestre_id', 'plan_academico.id as plan_id')->get();
        
        foreach ($planes as $plan) {
            if($plan->matricula) {
                $plan->have_matricula = Matricula::where('semestre_id', $plan->semestre_id)->where('alumno_id', auth()->user()->id)->first();
                array_push($data, $plan);
            }
        }

        return response()->json($data);
    }

    public function getPaso2ById($id){

        $matricula = Matricula::findOrFail($id);

        if($matricula->alumno_id !== auth()->user()->id){
            return response()->json('No tienes Permiso', 401);
        }

        $cursos = [];
        $myCursos = [];

        $data = [];

        if($matricula) {

            $cursos = SemestresCurso::join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
            ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->join('plan_periodos', 'plan_periodos.id', 'plan_cursos.plan_periodo_id')
            ->where('semestres_cursos.plan_id', $matricula->plan_id)
            ->where('semestres_cursos.semestre_id',  $matricula->semestre_id)
            ->select('semestres_cursos.id', 'semestres_cursos.grupo'
            , 'semestres_cursos.cupos', 'cursos.nombre', 'cursos.tipo', 'semestres_cursos.docente_id', 'plan_periodos.periodo'
            , 'semestres_cursos.plan_curso_id', 'plan_periodos.plan_academico_id', 'plan_cursos.creditos'
            , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica', 'semestres_cursos.id as semestres_curso_id')
            ->orderBy('semestres_cursos.grupo')->orderBy('plan_periodos.periodo', 'ASC')->orderBy('cursos.nombre', 'ASC')->get();

            foreach ($cursos as $curso) {
                $curso->docente     = User::where('id', $curso->docente_id)->select('nombres', 'apellido_paterno', 'apellido_materno')->first();

                $no_llevo    = PlanAlumnoNota::join('plan_alumnos', 'plan_alumnos.id', 'plan_alumnos_notas.plan_alumno_id')
                ->where('plan_alumnos_notas.plan_curso_id', $curso->plan_curso_id)
                ->where('plan_alumnos.alumno_id', auth()->user()->id)
                ->where('plan_alumnos.plan_academico_id', $curso->plan_academico_id)
                ->where(function ($query) {
                    $query->where('plan_alumnos_notas.estado', 0)
                          ->orWhere('plan_alumnos_notas.estado', 1);
                })->first();

                $curso->requisitos = [];
                $curso->llevo = true;
                $count = SemestresCursosAlumno::where('sem_cur_id', $curso->semestres_curso_id)->where('estado', 1)->count();
                $curso->cupos = $curso->cupos - $count;
                
                if($curso->cupos < 0){
                    $curso->cupos = 0;
                }

                if($no_llevo) {
                    $curso->llevo = false;
                    $curso->requisitos  = PlanRequisito::where('plan_requisitos.plan_curso_id', $curso->plan_curso_id)
                    ->join('cursos', 'cursos.id', 'plan_requisitos.requisito_id')
                    ->join('plan_cursos', 'plan_cursos.curso_id', 'cursos.id')
                    ->join('plan_periodos', 'plan_periodos.id', 'plan_cursos.plan_periodo_id')
                    ->where('plan_periodos.plan_academico_id', $curso->plan_academico_id)
                    ->select('cursos.nombre'
                    , 'cursos.id as curso_id'
                    , 'plan_cursos.curso_id as plan_cursos_curso_id'
                    , 'plan_cursos.id as plan_curso_id'
                    , 'plan_periodos.plan_academico_id'
                    , 'plan_requisitos.id as plan_requisitos_id'
                    , 'plan_requisitos.plan_curso_id as plan_requisitos_plan_curso_id'
                    , 'plan_requisitos.requisito_id')->get();
    
                    $curso_habilitado = true;
                    
                    foreach ($curso->requisitos as $requisito) {
                        $aprobo    = PlanAlumnoNota::join('plan_alumnos', 'plan_alumnos.id', 'plan_alumnos_notas.plan_alumno_id')
                        ->where('plan_alumnos_notas.plan_curso_id', $requisito->plan_curso_id)
                        ->where('plan_alumnos.alumno_id', auth()->user()->id)
                        ->where('plan_alumnos.plan_academico_id', $requisito->plan_academico_id)
                        ->where('plan_alumnos_notas.estado', 2)->first();

                        $requisito->aprobo = false;
                        $requisito->notas = $aprobo;

                        if($aprobo) {
                            $requisito->aprobo = true;
                        }else{
                            $curso_habilitado = false;
                        }
                    }
                    
                    $curso->habilitado = $curso_habilitado;

                }
            }

            $cursos = $cursos->groupBy(function ($val) {
                return $val->periodo;
            });
        }

        foreach ($cursos as $key => $curso) {
            $periodo = [];
            foreach ($curso as $item) {
                if($item->habilitado){
                    array_push($periodo, $item);
                }
            }
            $data_curso = [
                'periodo'   => $key,
                'cursos'    => $periodo,
            ];

            array_push($data, $data_curso);
        }

        if($matricula->estado == 2){
            $myCursosdata = SemestresCursosAlumno::join('semestres_cursos', 'semestres_cursos.id', 'semestres_cursos_alumnos.sem_cur_id')
            ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
            ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->join('plan_periodos', 'plan_periodos.id', 'plan_cursos.plan_periodo_id')
            ->where('semestres_cursos_alumnos.alum_id', auth()->user()->id)
            ->where('semestres_cursos_alumnos.matri_id', $matricula->id)
            ->select('cursos.nombre', 'plan_cursos.creditos', 'cursos.tipo'
            , 'plan_cursos.hora_practica', 'plan_cursos.hora_teorica', 'semestres_cursos.grupo'
            , 'semestres_cursos.cupos', 'semestres_cursos.plan_curso_id', 'semestres_cursos.docente_id'
            , 'plan_periodos.periodo', 'semestres_cursos_alumnos.sem_cur_id as semestres_curso_id')->get();
            
            foreach ($myCursosdata as $curso) {
                $count = SemestresCursosAlumno::where('sem_cur_id', $curso->semestres_curso_id)->where('estado', 1)->count();
                $curso->cupos = $curso->cupos - $count;
                if($curso->cupos < 0){
                    $curso->cupos = 0;
                }
                $curso->docente     = User::where('id', $curso->docente_id)->select('nombres', 'apellido_paterno', 'apellido_materno')->first();
            }

            $myCursosdata = $myCursosdata->groupBy(function ($val) {
                return $val->periodo;
            });

            
            foreach ($myCursosdata as $key => $curso) {
                $periodo = [];
                foreach ($curso as $item) {
                    array_push($periodo, $item);
                }
                $data_mycurso = [
                    'periodo'   => $key,
                    'cursos'    => $periodo,
                ];

                array_push($myCursos, $data_mycurso);
            }
        }

        return response()->json([
            'matricula' => $matricula,
            'cursos'    => $cursos,
            'myCursos'  => $myCursos,
            'data'      => $data,
        ], 200);
    }

    public function create(Request $request){

        $miTiempo = Carbon::now();

        $data = new Matricula();
        $data->semestre_id  = $request->semestre_id;
        $data->plan_id      = $request->plan_id;
        $data->alumno_id    = auth()->user()->id;
        $data->fecha_inicio = $miTiempo;
        $data->fecha_fin    = null;
        $data->estado       = 1;
        $data->save();

        return response()->json($data, 200);
    }

    public function matriculaPaso2(Request $request){
        $matricula = Matricula::findOrFail($request->matricula_id);

        if(count($request->listCursos) > 0){
            $data =Response::json($request->listCursos);
            $listPeriodos = $data->getData();
        }

        foreach ($listPeriodos as $key => $periodo) {
            foreach ($periodo->cursos as $key => $item) {
                $data = new SemestresCursosAlumno();
                $data->sem_cur_id           = $item->semestres_curso_id;
                $data->alum_id              = auth()->user()->id;
                $data->estado               = 0;
                $data->matri_id             = $matricula->id;
                $data->save();
            }
        }
        $matricula->estado = 2;
        $matricula->save();

        return response()->json(true, 200);
    }

    public function updatematriculaPaso2(Request $request){
        $matricula = Matricula::findOrFail($request->matricula_id);

        $cursos_pre_matriculados = SemestresCursosAlumno::where('alum_id', auth()->user()->id)
        ->where('matri_id', $matricula->id)->where('estado', 0)->get();

        if(count($request->listCursos) > 0){
            $data =Response::json($request->listCursos);
            $listPeriodos = $data->getData();
        }
        
        $list_ids   = [];
        $list_cursos = [];

        foreach ($listPeriodos as $key => $periodo) {
            foreach ($periodo->cursos as $key => $item) {
               array_push($list_cursos, $item);
               array_push($list_ids, $item->semestres_curso_id);
            }
        }
        
        $list_ids_created   = [];
        foreach ($cursos_pre_matriculados as $key => $item) {
            array_push($list_ids_created, $item->semestres_curso_id);
        }

        $list_create = [];
        foreach ($list_ids as $id) {
            if(!in_array($id, $list_ids_created)){
                array_push($list_create, $id);
            }
        }

        SemestresCursosAlumno::whereNotIn('sem_cur_id', $list_ids)
        ->where('alum_id', auth()->user()->id)
        ->where('matri_id', $matricula->id)
        ->where('estado', 0)->delete();

        foreach ($list_create as $id) {
            $data = new SemestresCursosAlumno();
            $data->sem_cur_id       = $id;
            $data->alum_id          = auth()->user()->id;
            $data->estado           = 0;
            $data->matri_id         = $matricula->id;
            $data->save();
        }


        $list_add = SemestresCursosAlumno::whereIn('sem_cur_id', $list_ids)
        ->where('alum_id', auth()->user()->id)
        ->where('matri_id', $matricula->id)
        ->where('estado', 0)->get();

        return response()->json(true, 200);
    }
}
