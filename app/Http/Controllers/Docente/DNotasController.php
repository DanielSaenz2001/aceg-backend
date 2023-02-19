<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matricula\SemestresCurso;
use App\Models\Matricula\SemestresCursosAlumno;
use App\Models\Docente\SemestresCursosEvaluacion;
use App\Models\Docente\EvaluacionesNota;
use Carbon\Carbon;
use Response;

class DNotasController extends Controller
{
    public function getAlumnos($id_curso, $id_evaluacion){
        $curso  = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->where('semestres_cursos.docente_id', auth()->user()->id)
        ->where('semestres_cursos.id', $id_curso)
        ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
        , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica', 'semestres_cursos.grupo'
        ,'semestres.estado as semestre_estado')->first();

        $evaluacion = SemestresCursosEvaluacion::findOrFail($id_evaluacion);
        
        $alumnos = SemestresCursosAlumno::join('users', 'users.id', 'semestres_cursos_alumnos.alum_id')
        ->where('semestres_cursos_alumnos.estado', 1)
        ->where('semestres_cursos_alumnos.sem_cur_id', $id_curso)
        ->select('users.id as user_id', 'users.nombres', 'users.apellido_paterno'
        , 'users.apellido_materno', 'users.dni', 'users.sexo')
        ->get();

        $estado = false;
        $theDate = Carbon::parse($evaluacion->fecha)->addDays(7)->format('Y-m-d');
        $miTiempo = Carbon::now()->format('Y-m-d');

        if($curso->semestre_estado){
            if($miTiempo < $theDate) {
                $estado = true;
            }
        }

        foreach ($alumnos as $alumno) {
            $alumno->nota = null;
            $alumno->evaluacion = EvaluacionesNota::where('evaluacion_id', $id_evaluacion)
            ->where('alumno_id', $alumno->user_id)->first();
            $alumno->new             = true;
            $alumno->state           = 'old';

            if($alumno->evaluacion){
                $alumno->new = false;
                $alumno->nota = $alumno->evaluacion->nota;
            }
        }

        return response()->json([
            'curso'         => $curso,
            'evaluacion '   => $evaluacion,
            'alumnos'       => $alumnos,
            'estado'        => $estado
        ], 200);
    }

    public function create(Request $request){
        $listAlumnos = [];

        if(count($request->data) > 0){
            $data = Response::json($request->data);
            $listAlumnos = $data->getData();
        }

        $evaluacion = SemestresCursosEvaluacion::findOrFail($request->evaluacion_id);

        $theDate = Carbon::parse($evaluacion->fecha)->addDays(7)->format('Y-m-d');
        $miTiempo = Carbon::now()->format('Y-m-d');

        if($curso->semestre_estado){
            if($miTiempo > $theDate) {
                return response()->json([
                    'message' => 'Ya se paso la fecha para la asistencia'
                ], 401);
            }
        }


        foreach ($listAlumnos as $item) {
            if($item->state == "new" && $item->new == false){
                EvaluacionesNota::where('alumno_id', $item->user_id)
                ->where('evaluacion_id', $request->evaluacion_id)
                ->update(['nota'=> $item->nota]);
            }else{
                $data = new EvaluacionesNota();
                $data->evaluacion_id    = $request->evaluacion_id;
                $data->alumno_id        = $item->user_id;
                $data->nota             = $item->nota;
                $data->save();
            }
        }
        return $this->getAlumnos($request->semestre_curso_id, $request->evaluacion_id);
    }
}
