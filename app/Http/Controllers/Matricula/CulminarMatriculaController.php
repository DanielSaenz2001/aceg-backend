<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Sede;
use App\Models\Administrativo\SedesFacultades;
use App\Models\Administrativo\FacultadesCarreras;
use App\Models\Administrativo\PlanAcademico;
use App\Models\Administrativo\Semestre;
use App\Models\Matricula\Matricula;
use App\Models\Matricula\SemestresCursosAlumno;
use Carbon\Carbon;

class CulminarMatriculaController extends Controller
{
    public function getSedes(){

        $sedes      = Sede::all();
        $semestres  = Semestre::where('estado', true)->where('nombre', 'LIKE' , '%'.date("Y").'%')->get();

        return response()->json([
            'sedes'     => $sedes,
            'semestres' => $semestres
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

    public function getMatriculados($semestre_id, $plan_id){
        $data  = Matricula::join('users', 'users.id', 'matriculas.alumno_id')
        ->where('matriculas.semestre_id', $semestre_id)
        ->where('matriculas.plan_id', $plan_id)
        ->where('matriculas.estado', 2)
        ->select('users.nombres', 'users.apellido_paterno', 'users.apellido_materno'
        , 'users.sexo', 'users.direccion', 'users.sexo', 'users.email'
        , 'users.celular', 'users.dni', 'users.id as user_id', 'matriculas.id as matricula_id')
        ->orderBy('users.apellido_paterno', 'ASC')->orderBy('users.apellido_materno', 'ASC')->orderBy('users.nombres', 'ASC')->get();

        return response()->json($data, 200);
    }

    public function getById($matricula_id){
        $data = SemestresCursosAlumno::join('semestres_cursos', 'semestres_cursos.id', 'semestres_cursos_alumnos.sem_cur_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->where('semestres_cursos_alumnos.matri_id', $matricula_id)
        ->select('cursos.nombre', 'plan_cursos.creditos', 'cursos.tipo'
            , 'plan_cursos.hora_practica', 'plan_cursos.hora_teorica', 'semestres_cursos.grupo'
            , 'semestres_cursos.cupos')->get();

        return response()->json($data, 200);
    }

    public function paso3($matricula_id){
        $miTiempo = Carbon::now();
        $matricula = Matricula::findOrFail($matricula_id);

        $matricula->fecha_fin = $miTiempo;
        $matricula->estado    = 3;

        SemestresCursosAlumno::where('matri_id', $matricula_id)->update(['estado'=> 1]);

        $matricula->save();

        return response()->json(true, 200);
    }
}
