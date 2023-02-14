<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\PlanAlumno;
use App\Models\Matricula\Matricula;
use Carbon\Carbon;

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
        ->where('semestres.estado', true)->where('alumno_id', auth()->user()->id)
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

        return response()->json([
            'matricula' => $matricula
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
}
