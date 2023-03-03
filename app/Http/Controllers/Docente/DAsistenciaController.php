<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matricula\SemestresCurso;
use App\Models\Matricula\SemestresCursosAlumno;
use App\Models\Docente\SemestresCursosAsistencia;
use Carbon\Carbon;
use Response;

class DAsistenciaController extends Controller
{
    public function getAlumnos($id, $date){
        $curso  = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->where('semestres_cursos.docente_id', auth()->user()->id)
        ->where('semestres_cursos.id', $id)
        ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
        , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica', 'semestres_cursos.grupo' ,'semestres.estado as semestre_estado')->first();
        
        $alumnos = SemestresCursosAlumno::join('users', 'users.id', 'semestres_cursos_alumnos.alum_id')
        ->where('semestres_cursos_alumnos.estado', 1)
        ->where('semestres_cursos_alumnos.sem_cur_id', $id)
        ->select('users.id as user_id', 'users.nombres', 'users.apellido_paterno'
        , 'users.apellido_materno', 'users.dni', 'users.sexo')
        ->get();

        foreach ($alumnos as $alumno) {
            $alumno->asistencia = SemestresCursosAsistencia::where('sem_cur_id', $id)
            ->where('alum_id', $alumno->user_id)->whereDate('fecha', $date)->first();

            $alumno->new             = true;
            $alumno->type_asistencia = 1;
            $alumno->state           = 'old';
            if($alumno->asistencia) {
                if($alumno->asistencia->estado == 1) {
                    $alumno->type_asistencia = 1;
                }else if($alumno->asistencia->estado == 0) {
                    $alumno->type_asistencia = 0;
                }else{
                    $alumno->type_asistencia = 2;
                }
                $alumno->new = false;
            }
        }

        $estado = false;
        $theDate = Carbon::createFromFormat('Y-m-d', $date)->addDays(7)->format('Y-m-d');
        $miTiempo = Carbon::now()->format('Y-m-d');


        if($curso->semestre_estado){
            if($miTiempo < $theDate) {
                $estado = true;
            }
        }

        return response()->json([
            'curso'   => $curso,
            'alumnos' => $alumnos,
            'estado'  => $estado,
        ], 200);
    }

    public function create(Request $request){
        $listAlumnos = [];

        if(count($request->data) > 0){
            $data = Response::json($request->data);
            $listAlumnos = $data->getData();
        }

        
        $estado = false;
        $theDate = Carbon::parse($request->fecha)->addDays(7)->format('Y-m-d');
        $miTiempo = Carbon::now()->format('Y-m-d');

        $curso = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->where('semestres_cursos.id', $request->semestre_curso_id)->select('semestres.estado as semestre_estado')
        ->first();

        if($curso->semestre_estado){
            if($miTiempo > $theDate) {
                $estado = true;

                return response()->json([
                    'message' => 'Ya se paso la fecha para la asistencia'
                ], 401);
            }
        }

        foreach ($listAlumnos as $item) {
            if($item->state == "new" && $item->new == false){
                SemestresCursosAsistencia::where('alum_id', $item->user_id)
                ->where('sem_cur_id', $request->semestre_curso_id)
                ->where('fecha', $request->fecha)
                ->update(['estado'=> $item->type_asistencia]);
            }else{
                $data = new SemestresCursosAsistencia();
                $data->sem_cur_id       = $request->semestre_curso_id;
                $data->alum_id          = $item->user_id;
                $data->fecha            = $request->fecha;
                $data->estado           = $item->type_asistencia;
                $data->justificacion    = "";
                $data->save();
            }
        }
        return $this->getAlumnos($request->semestre_curso_id, $request->fecha);
    }

    public function update($id, Request $request){

        return $this->getAlumnos($request->semestre_curso_id, $request->fecha);
    }

    public function justificar($id, Request $request){

    }
}
