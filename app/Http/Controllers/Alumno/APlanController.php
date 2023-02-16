<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matricula\Matricula;
use App\Models\Administrativo\PlanAlumno;
use App\Models\Administrativo\PlanAlumnoNota;
use App\Models\Administrativo\PlanPeriodo;
use App\Models\Administrativo\PlanCurso;
use App\Models\Administrativo\PlanRequisito;

class APlanController extends Controller
{
    public function getPlanes(){
        $matricula  = Matricula::where('alumno_id', auth()->user()->id)
        ->where('estado', 3)->orderBy('id', 'DESC')->first();

        $plan = PlanAlumno::join('plan_academico', 'plan_academico.id', 'plan_alumnos.plan_academico_id')
        ->join('facultades_carreras', 'facultades_carreras.id', 'plan_academico.facultad_carrera_id')
        ->join('sedes_facultades', 'sedes_facultades.id', 'facultades_carreras.sede_facultad_id')
        ->join('semestres', 'semestres.id', 'plan_academico.semestre_id')
        ->join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
        ->join('facultades', 'facultades.id', 'sedes_facultades.facultad_id')
        ->where('plan_alumnos.plan_academico_id', $matricula->plan_id)
        ->where('plan_alumnos.alumno_id', auth()->user()->id)
        ->select('plan_alumnos.*', 'semestres.nombre as semestre', 'carreras.nombre as carrera'
        , 'facultades.nombre as facultad')->first();

        $planes = PlanAlumno::join('plan_academico', 'plan_academico.id', 'plan_alumnos.plan_academico_id')
        ->join('facultades_carreras', 'facultades_carreras.id', 'plan_academico.facultad_carrera_id')
        ->join('sedes_facultades', 'sedes_facultades.id', 'facultades_carreras.sede_facultad_id')
        ->join('semestres', 'semestres.id', 'plan_academico.semestre_id')
        ->join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
        ->join('facultades', 'facultades.id', 'sedes_facultades.facultad_id')
        ->where('plan_alumnos.alumno_id', auth()->user()->id)
        ->select('plan_alumnos.*', 'semestres.nombre as semestre', 'carreras.nombre as carrera'
        , 'facultades.nombre as facultad')->get();

        $periodos  = PlanPeriodo::where('plan_academico_id', $plan->plan_academico_id)
        ->orderBy('periodo', 'ASC')->get();

        foreach ($periodos as $periodo) {
            $periodo->cursos = PlanCurso::join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->where('plan_cursos.plan_periodo_id', $periodo->id)
            ->select('cursos.*', 'plan_cursos.id as pl_curs_id', 'plan_cursos.plan_periodo_id as pl_curs_plan_periodo_id',
            'plan_cursos.curso_id as pl_curs_curso_id', 'plan_cursos.creditos as pl_curs_creditos', 
            'plan_cursos.hora_teorica as pl_curs_hora_teorica', 'plan_cursos.hora_practica as pl_curs_hora_practica', 
            'plan_cursos.nota_minima as pl_curs_nota_minima')
            ->orderBy('cursos.nombre', 'ASC')->get();

            foreach ($periodo->cursos as $curso) {
                $nota = PlanAlumnoNota::where('plan_alumno_id', $plan->id)->where('plan_curso_id', $curso->pl_curs_curso_id)->first();

                $curso->nota = null;
                $curso->notaPromediada = null;

                if($nota) {
                    $curso->nota = $nota->nota;
                    $curso->notaPromediada = round($nota->nota, 0);
                }
            }
        }

        return response()->json([
            'planes' => $planes,
            'plan'   => $plan,
            'periodos' => $periodos,
        ], 200);
    }

    public function getRequisitos($curso_id){

        $data = PlanRequisito::join('cursos', 'cursos.id', 'plan_requisitos.requisito_id')
        ->where('plan_requisitos.plan_curso_id', $curso_id)
        ->select('cursos.*', 'plan_requisitos.id as pl_req_id', 'plan_requisitos.plan_curso_id as pl_req_plan_curso_id',
        'plan_requisitos.requisito_id as pl_req_requisito_id')
        ->orderBy('cursos.nombre', 'ASC')->get();

        return response()->json($data, 200);
    }
    public function getPlanesByPlan($id){

        $plan = PlanAlumno::join('plan_academico', 'plan_academico.id', 'plan_alumnos.plan_academico_id')
        ->join('facultades_carreras', 'facultades_carreras.id', 'plan_academico.facultad_carrera_id')
        ->join('sedes_facultades', 'sedes_facultades.id', 'facultades_carreras.sede_facultad_id')
        ->join('semestres', 'semestres.id', 'plan_academico.semestre_id')
        ->join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
        ->join('facultades', 'facultades.id', 'sedes_facultades.facultad_id')
        ->where('plan_alumnos.plan_academico_id', $id)
        ->where('plan_alumnos.alumno_id', auth()->user()->id)
        ->select('plan_alumnos.*', 'semestres.nombre as semestre', 'carreras.nombre as carrera'
        , 'facultades.nombre as facultad')->first();

        $periodos  = PlanPeriodo::where('plan_academico_id', $id)
        ->orderBy('periodo', 'ASC')->get();

        foreach ($periodos as $periodo) {
            $periodo->cursos = PlanCurso::join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->where('plan_cursos.plan_periodo_id', $periodo->id)
            ->select('cursos.*', 'plan_cursos.id as pl_curs_id', 'plan_cursos.plan_periodo_id as pl_curs_plan_periodo_id',
            'plan_cursos.curso_id as pl_curs_curso_id', 'plan_cursos.creditos as pl_curs_creditos', 
            'plan_cursos.hora_teorica as pl_curs_hora_teorica', 'plan_cursos.hora_practica as pl_curs_hora_practica', 
            'plan_cursos.nota_minima as pl_curs_nota_minima')
            ->orderBy('cursos.nombre', 'ASC')->get();

            foreach ($periodo->cursos as $curso) {
                $nota = PlanAlumnoNota::where('plan_alumno_id', $plan->id)->where('plan_curso_id', $curso->pl_curs_curso_id)->first();

                $curso->nota = null;
                $curso->notaPromediada = null;

                if($nota) {
                    $curso->nota = $nota->nota;
                    $curso->notaPromediada = round($nota->nota, 0);
                }
            }
        }

        return response()->json([
            'plan' => $plan,
            'periodos' => $periodos
        ], 200);
    }
}
