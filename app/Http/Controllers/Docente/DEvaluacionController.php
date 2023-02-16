<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matricula\SemestresCurso;
use App\Models\Docente\SemestresCursosEvaluacion;
use App\Models\Docente\EvaluacionesNota;
use App\Models\Matricula\SemestresCursosAlumno;
use App\Models\Administrativo\PlanAlumnoNota;

class DEvaluacionController extends Controller
{
    public function getEvaluaciones($id){
        $curso  = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->where('semestres_cursos.docente_id', auth()->user()->id)
        ->where('semestres_cursos.id', $id)
        ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
        , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica', 'semestres_cursos.grupo')->first();
        
        $evaluaciones = SemestresCursosEvaluacion::where('sem_cur_id', $id)
        ->get();

        return response()->json([
            'curso'         => $curso,
            'evaluaciones'  => $evaluaciones
        ], 200);
    }

    public function getById($id){
        $evaluacion = SemestresCursosEvaluacion::findOrFail($id);
        
        return response()->json($evaluacion, 200);
    }

    public function create(Request $request){
        $data = new SemestresCursosEvaluacion();

        $data->sem_cur_id   = $request->sem_cur_id;
        $data->nombre       = $request->nombre;
        $data->fecha        = $request->fecha;
        $data->porcentaje   = $request->porcentaje;

        $data->save();

        return $this->getEvaluaciones($request->sem_cur_id);
    }

    public function update($id, Request $request){
        $data = SemestresCursosEvaluacion::findOrFail($id);

        $data->nombre       = $request->nombre;
        $data->fecha        = $request->fecha;
        $data->porcentaje   = $request->porcentaje;

        $data->save();

        return $this->getEvaluaciones($data->sem_cur_id);
    }

    public function destroyEvaluaciones($id){
        
        $evaluacion = SemestresCursosEvaluacion::findOrFail($id);
        $evaluacion->delete();
        
        return $this->getEvaluaciones($evaluacion->sem_cur_id);
    }
    
    public function upNotas($id){
        $curso  = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('plan_periodos', 'plan_periodos.id', 'plan_cursos.plan_periodo_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->where('semestres_cursos.docente_id', auth()->user()->id)
        ->where('semestres_cursos.id', $id)
        ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
        , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica'
        , 'semestres_cursos.grupo', 'semestres_cursos.plan_curso_id'
        , 'plan_periodos.plan_academico_id', 'plan_cursos.nota_minima')->first();

        $alumnos = SemestresCursosAlumno::join('users', 'users.id', 'semestres_cursos_alumnos.alum_id')
        ->where('semestres_cursos_alumnos.estado', 1)
        ->where('semestres_cursos_alumnos.sem_cur_id', $curso->id)
        ->select('users.id as user_id', 'users.nombres', 'users.apellido_paterno'
        , 'users.apellido_materno', 'users.dni', 'users.sexo')
        ->get();

        foreach ($alumnos as $alumno) {
            $notas = EvaluacionesNota::join('semestres_cursos_evaluaciones', 'semestres_cursos_evaluaciones.id', 'evaluaciones_notas.evaluacion_id')
            ->where('semestres_cursos_evaluaciones.sem_cur_id', $curso->id)
            ->where('evaluaciones_notas.alumno_id', $alumno->user_id)->get();

            $promedioFinal = 0;

            foreach ($notas as $nota) {
                $promedioFinal = $promedioFinal + (($nota->nota * $nota->porcentaje)/100);
            }
            $alumno->promedioFinal = round($promedioFinal, 2);
            $alumno->promedioFinalRedondeado = round($promedioFinal, 0);

            $plan_alumno_nota = PlanAlumnoNota::join('plan_alumnos', 'plan_alumnos.id', 'plan_alumnos_notas.plan_alumno_id')
            ->where('plan_alumnos_notas.plan_curso_id', $curso->plan_curso_id)
            ->where('plan_alumnos.plan_academico_id', $curso->plan_academico_id)
            ->where('plan_alumnos.alumno_id', $alumno->user_id)
            ->select('plan_alumnos_notas.*')->first();

            $plan_alumno_nota->nota = $alumno->promedioFinal;

            $plan_alumno_nota->estado = 1;

            if($curso->nota_minima <=  $alumno->promedioFinalRedondeado){
                $plan_alumno_nota->estado = 2;
            }

            $plan_alumno_nota->save();

            $alumno->plan_alumno_nota = $plan_alumno_nota;
        }

        return response()->json($alumnos, 200);
    }
}
