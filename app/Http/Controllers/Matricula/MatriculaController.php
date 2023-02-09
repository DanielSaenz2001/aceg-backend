<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function getSedes($alumno_id){

        $sedes  = Sede::all();

        return response()->json($sedes, 200);
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
}
