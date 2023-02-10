<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Sede;
use App\Models\Administrativo\SedesFacultades;
use App\Models\Administrativo\FacultadesCarreras;
use App\Models\Administrativo\PlanAcademico;
use App\Models\Administrativo\PlanAlumno;
use App\Models\Administrativo\Semestre;

class MatriculaController extends Controller
{
    public function getSedes(){

        $sedes  = Sede::all();
        $semestres  = Semestre::orderBy('nombre', 'desc')->get();

        return response()->json([
            'sedes' => $sedes,
            'semestres' => $semestres,
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

    public function search($plan_id, $anhio){

        $result = PlanAlumno::where('plan_alumnos.semestre_id', $anhio)->where('plan_alumnos.plan_academico_id', $plan_id)
        ->join('users', 'users.id', 'plan_alumnos.alumno_id')
        ->select('users.nombres', 'users.apellido_paterno', 'users.apellido_materno', 'users.sexo'
        , 'users.direccion', 'users.sexo', 'users.email', 'users.celular', 'users.dni')
        ->get();
        return response()->json($result, 200);
    }
}
