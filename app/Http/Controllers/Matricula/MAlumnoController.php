<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Administrativo\PlanAlumno;
use App\Models\Administrativo\Sede;
use App\Models\Administrativo\SedesFacultades;
use App\Models\Administrativo\FacultadesCarreras;
use App\Models\Administrativo\PlanAcademico;
use App\Models\Administrativo\PlanPeriodo;
use App\Models\Administrativo\PlanCurso;
use App\Models\Administrativo\PlanAlumnoNota;
use App\Models\Administrativo\Semestre;

class MAlumnoController extends Controller
{

    public function filtro($paterno, $materno, $nombres, $dni){

        if($paterno == "null"){
            $paterno = null;
        }
        if($materno == "null"){
            $materno = null;
        }
        if($nombres == "null"){
            $nombres = null;
        }
        if($dni     == "null"){
            $dni     = null;
        }

        $alumnos = User::join('permiso_users', 'permiso_users.user_id', 'users.id')
        ->join('permisos', 'permisos.id', 'permiso_users.permiso_id')
        ->where('permisos.codigo', 'Alumno')
        ->where('users.estado', true)
        ->paterno($paterno)->materno($materno)
        ->nombre($nombres)->dni($dni)->paginate(20);

        return response()->json($alumnos);

    }

    public function getPlanesAlumno($alumno_id){
        $plan_alumnos = PlanAlumno::join('plan_academico', 'plan_academico.id', 'plan_alumnos.plan_academico_id')
        ->join('semestres', 'semestres.id', 'plan_academico.semestre_id')
        ->join('facultades_carreras', 'facultades_carreras.id', 'plan_academico.facultad_carrera_id')
        ->join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
        ->join('facultades', 'facultades.id', 'carreras.facultad_id')
        ->where('plan_alumnos.estado', true)->where('alumno_id', $alumno_id)
        ->select('semestres.nombre', 'carreras.nombre as carrera', 'facultades.nombre as facultad')->get();

        $sedes  = Sede::all();

        $semestres  = Semestre::where('estado', true)->where('nombre', 'LIKE' , '%'.date("Y").'%')->get();

        return response()->json([
            'plan_alumnos'  =>  $plan_alumnos,
            'sedes'         =>  $sedes,
            'semestres'     =>  $semestres,
        ], 200);
    }

    public function getFacultades($sede_id){
        $facultades  = SedesFacultades::join('facultades', 'facultades.id', 'sedes_facultades.facultad_id')
        ->where('sedes_facultades.sede_id', $sede_id)->select('facultades.*', 'sedes_facultades.id as sede_facul_id')->get();

        return response()->json($facultades, 200);
    }

    public function getCarreras($facultad_id){
        $carreras  = FacultadesCarreras::join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
        ->where('facultades_carreras.sede_facultad_id', $facultad_id)
        ->select('carreras.*', 'facultades_carreras.id as facul_carrera_id')->get();

        return response()->json($carreras, 200);
    }

    public function getPlanes($carrera_id){
        $planes  = PlanAcademico::join('semestres', 'semestres.id', 'plan_academico.semestre_id')
        ->where('plan_academico.facultad_carrera_id', $carrera_id)
        ->select('semestres.*', 'plan_academico.id as plan_semes_id')->orderBy('semestres.nombre', 'ASC')->get();

        return response()->json($planes, 200);
    }

    public function getPeriodos($plan_id){

        $periodos  = PlanPeriodo::where('plan_academico_id', $plan_id)
        ->orderBy('periodo', 'ASC')->get();


        foreach ($periodos as $periodo) {
            $periodo->cursos = PlanCurso::join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->where('plan_cursos.plan_periodo_id', $periodo->id)
            ->select('cursos.*', 'plan_cursos.id as pl_curs_id', 'plan_cursos.plan_periodo_id as pl_curs_plan_periodo_id',
            'plan_cursos.curso_id as pl_curs_curso_id', 'plan_cursos.creditos as pl_curs_creditos', 
            'plan_cursos.hora_teorica as pl_curs_hora_teorica', 'plan_cursos.hora_practica as pl_curs_hora_practica', 
            'plan_cursos.nota_minima as pl_curs_nota_minima')
            ->orderBy('cursos.nombre', 'ASC')->get();
        }

        return response()->json($periodos, 200);
    }

    public function getRequisitos($curso_id){

        $requisitos = PlanRequisito::join('cursos', 'cursos.id', 'plan_requisitos.requisito_id')
        ->where('plan_requisitos.plan_curso_id', $curso_id)
        ->select('cursos.*', 'plan_requisitos.id as pl_req_id', 'plan_requisitos.plan_curso_id as pl_req_plan_curso_id',
        'plan_requisitos.requisito_id as pl_req_requisito_id')
        ->orderBy('cursos.nombre', 'ASC')->get();

        return response()->json($requisitos, 200);
    }

    public function savePlanAlumno(Request $request){
        $planAlumno = new PlanAlumno();

        $planAlumno->plan_academico_id  = $request->plan_academico_id;
        $planAlumno->alumno_id          = $request->alumno_id;
        $planAlumno->semestre_id        = $request->semestre_id;
        $planAlumno->anhio              = date("Y");
        $planAlumno->estado             = true;

        $planAlumno->save();

        $periodos  = PlanPeriodo::where('plan_academico_id', $request->plan_academico_id)
        ->orderBy('periodo', 'ASC')->get();

        foreach ($periodos as $periodo) {
            $periodo->cursos = PlanCurso::where('plan_periodo_id', $periodo->id)->get();
            foreach ($periodo->cursos as $curso) {
                $planNota = new PlanAlumnoNota();
                $planNota->plan_alumno_id   = $planAlumno->id;
                $planNota->plan_curso_id    = $curso->id;
                $planNota->nota             = null;
                $planNota->estado           = 0;
                $planNota->save();
            }
        }

        return $this->getPlanesAlumno($request->alumno_id);
    }
}
