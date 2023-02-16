<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matricula\SemestresCurso;
use App\Models\Matricula\SemestresCursosAlumno;
use App\Models\Matricula\Matricula;
use App\Models\Docente\SemestresCursosEvaluacion;
use App\Models\Docente\EvaluacionesNota;
use App\Models\Docente\SemestresCursosAsistencia;

class ACursosController extends Controller
{
    
    public function getCursos(){
        $matricula  = Matricula::join('semestres', 'semestres.id', 'matriculas.semestre_id')
        ->where('matriculas.alumno_id', auth()->user()->id)
        ->where('matriculas.estado', 3)
        ->select('matriculas.*', 'semestres.nombre')->orderBy('id', 'DESC')->first();

        $matriculas = Matricula::join('semestres', 'semestres.id', 'matriculas.semestre_id')
        ->where('matriculas.alumno_id', auth()->user()->id)
        ->where('matriculas.estado', 3)
        ->select('matriculas.*', 'semestres.nombre')->orderBy('id', 'DESC')->get();

        $cursos = [];
        if($matricula){
            $cursos = SemestresCursosAlumno::join('semestres_cursos', 'semestres_cursos.id', 'semestres_cursos_alumnos.sem_cur_id')
            ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
            ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->join('plan_periodos', 'plan_periodos.id', 'plan_cursos.plan_periodo_id')
            ->join('plan_academico', 'plan_academico.id', 'plan_periodos.plan_academico_id')
            ->join('facultades_carreras', 'facultades_carreras.id', 'plan_academico.facultad_carrera_id')
            ->join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
            ->where('semestres_cursos.plan_id', $matricula->plan_id)
            ->where('semestres_cursos.semestre_id', $matricula->semestre_id)
            ->where('semestres_cursos_alumnos.estado', '!=', 0)
            ->where('semestres_cursos_alumnos.alum_id', auth()->user()->id)
            ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
            , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica'
            , 'semestres_cursos.grupo', 'plan_periodos.periodo', 'carreras.nombre as carrera')
            ->orderBy('periodo', 'ASC')->orderBy('grupo', 'ASC')->orderBy('nombre', 'ASC')->get();
        }

        return response()->json([
            'matriculas' => $matriculas,
            'matricula'  => $matricula,
            'cursos'     => $cursos,
        ], 200);
    }
    
    public function getCursosByOtherMatricula($matricula_id){
        $matricula  = Matricula::findOrFail($matricula_id);

        $cursos = [];
        if($matricula){
            $cursos = SemestresCursosAlumno::join('semestres_cursos', 'semestres_cursos.id', 'semestres_cursos_alumnos.sem_cur_id')
            ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
            ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->join('plan_periodos', 'plan_periodos.id', 'plan_cursos.plan_periodo_id')
            ->join('plan_academico', 'plan_academico.id', 'plan_periodos.plan_academico_id')
            ->join('facultades_carreras', 'facultades_carreras.id', 'plan_academico.facultad_carrera_id')
            ->join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
            ->where('semestres_cursos.plan_id', $matricula->plan_id)
            ->where('semestres_cursos.semestre_id', $matricula->semestre_id)
            ->where('semestres_cursos_alumnos.estado', '!=', 0)
            ->where('semestres_cursos_alumnos.alum_id', auth()->user()->id)
            ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
            , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica'
            , 'semestres_cursos.grupo', 'plan_periodos.periodo', 'carreras.nombre as carrera')
            ->orderBy('periodo', 'ASC')->orderBy('grupo', 'ASC')->orderBy('nombre', 'ASC')->get();
        }

        return response()->json($cursos, 200);
    }
    
    public function getEvaluaciones($id){
        $curso  = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->where('semestres_cursos.id', $id)
        ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
        , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica', 'semestres_cursos.grupo')->first();
        
        $evaluaciones = SemestresCursosEvaluacion::where('sem_cur_id', $id)
        ->get();

        $promedioFinal = 0;
        foreach ($evaluaciones as $evaluacion) {
            $notas = EvaluacionesNota::where('alumno_id', auth()->user()->id)
            ->where('evaluacion_id', $evaluacion->id)->first();

            $evaluacion->nota = null;
            if($notas) {
                $evaluacion->nota = $notas->nota;
                $promedioFinal = $promedioFinal + (($evaluacion->nota * $evaluacion->porcentaje)/100);
            }
        }
        $promedioFinal = round($promedioFinal, 2);
        $promedioFinalRedondeado = round($promedioFinal, 0);
        

        return response()->json([
            'curso'         => $curso,
            'evaluaciones'  => $evaluaciones,
            'promedioFinalRedondeado'  => $promedioFinalRedondeado,
        ], 200);
    }

    public function getAsistencia($id){
        $curso  = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->where('semestres_cursos.id', $id)
        ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
        , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica', 'semestres_cursos.grupo')->first();
        
        $asistencias = SemestresCursosAsistencia::where('alum_id', auth()->user()->id)
        ->where('sem_cur_id', $id)->get();

        return response()->json([
            'curso'         => $curso,
            'asistencias'  => $asistencias,
        ], 200);
    }

}
