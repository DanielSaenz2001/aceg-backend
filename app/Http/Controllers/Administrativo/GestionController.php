<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Sede;
use App\Models\Administrativo\SedesFacultades;
use App\Models\Administrativo\Facultad;
use App\Models\Administrativo\FacultadesCarreras;
use App\Models\Administrativo\Carrera;
use App\Models\Administrativo\PlanAcademico;
use App\Models\Administrativo\Semestre;

class GestionController extends Controller
{
    public function getSedes(){
        $sedes  = Sede::all();

        return response()->json($sedes);
    }

    public function getFacultadesDetailSede($sede_id){
        $sede        = Sede::findOrFail($sede_id);

        $Myfacultades  = SedesFacultades::join('facultades', 'facultades.id', 'sedes_facultades.facultad_id')
        ->where('sedes_facultades.sede_id', $sede_id)->select('facultades.*', 'sedes_facultades.sede_id as sede_facul_sede_id'
        , 'sedes_facultades.facultad_id as sede_facul_facultad_id', 'sedes_facultades.id as sede_facul_id'
        , 'sedes_facultades.estado as sede_facul_estado')->get();

        $facultadesAvoid = [];

        for ($i=0; $i < count($Myfacultades); $i++) {
            $facultadesAvoid[$i] = $Myfacultades[$i]['id'];
        }

        $facultades = Facultad::whereNotIn('id', $facultadesAvoid)->where('estado', true)->get();

        return response()->json([
            'sede'          => $sede,
            'Myfacultades'  => $Myfacultades,
            'facultades'    => $facultades,
        ], 200);
    }

    public function addFacultadesSede(Request $request){
        $sedeFacultad = new SedesFacultades();

        $sedeFacultad->sede_id      = $request->sede_id;
        $sedeFacultad->facultad_id  = $request->facultad_id;
        $sedeFacultad->estado       = $request->estado;
        
        $sedeFacultad->save();

        return $this->getFacultadesDetailSede($request->sede_id);
    }

    public function updateFacultadesSede($id, Request $request){
        $sedeFacultad = SedesFacultades::findOrFail($id);

        $sedeFacultad->facultad_id  = $request->facultad_id;
        $sedeFacultad->estado       = $request->estado;
        
        $sedeFacultad->save();

        return $this->getFacultadesDetailSede($sedeFacultad->sede_id);
    }

    public function deleteFacultadesSede($id, Request $request){
        $sedeFacultad = SedesFacultades::findOrFail($id);

        $sedeFacultad->delete();

        return $this->getFacultadesDetailSede($sedeFacultad->sede_id);
    }

    public function getCarrerasDetailFacultad($facultad_id){
        $facultad        = Facultad::findOrFail($facultad_id);

        $MyCarreras  = FacultadesCarreras::join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
        ->where('facultades_carreras.sede_facultad_id', $facultad_id)
        ->select('carreras.*', 'facultades_carreras.sede_facultad_id as sede_facul_sede_facultad_id'
        , 'facultades_carreras.carrera_id as sede_facul_carrera_id', 'facultades_carreras.id as sede_facul_id'
        , 'facultades_carreras.estado as sede_facul_estado')->get();

        $carrerasAvoid = [];

        for ($i=0; $i < count($MyCarreras); $i++) {
            $carrerasAvoid[$i] = $MyCarreras[$i]['id'];
        }

        $carreras = Carrera::whereNotIn('id', $carrerasAvoid)->where('estado', true)->get();

        return response()->json([
            'facultad'      => $facultad,
            'MyCarreras'    => $MyCarreras,
            'carreras'      => $carreras,
        ], 200);
    }

    public function addCarrerasFacultad(Request $request){
        $facultadCarrera = new FacultadesCarreras();

        $facultadCarrera->sede_facultad_id    = $request->sede_facultad_id;
        $facultadCarrera->carrera_id          = $request->carrera_id;
        $facultadCarrera->estado              = $request->estado;
        
        $facultadCarrera->save();

        return $this->getCarrerasDetailFacultad($request->facultad_id);
    }

    public function updateCarrerasFacultad($id, Request $request){
        $facultadCarrera = FacultadesCarreras::findOrFail($id);

        $facultadCarrera->carrera_id          = $request->carrera_id;
        $facultadCarrera->estado              = $request->estado;
        
        $facultadCarrera->save();

        return $this->getCarrerasDetailFacultad($facultadCarrera->facultad_id);
    }

    public function deleteCarrerasFacultad($id, Request $request){
        $facultadCarrera = FacultadesCarreras::findOrFail($id);

        $facultadCarrera->delete();

        return $this->getCarrerasDetailFacultad($facultadCarrera->facultad_id);
    }

    public function getPlanesDetailCarrera($carrera_id){
        $carrera        = Carrera::findOrFail($carrera_id);

        $MyPlanes  = PlanAcademico::join('semestres', 'semestres.id', 'plan_academico.semestre_id')
        ->where('plan_academico.facultad_carrera_id', $carrera_id)
        ->select('semestres.*', 'plan_academico.semestre_id as sede_facul_semestre_id'
        , 'plan_academico.facultad_carrera_id as sede_facul_facultad_carrera_id', 'plan_academico.id as sede_facul_id'
        , 'plan_academico.estado as sede_facul_estado')->get();

        $planesAvoid = [];

        for ($i=0; $i < count($MyPlanes); $i++) {
            $planesAvoid[$i] = $MyPlanes[$i]['sede_facul_semestre_id'];
        }

        $semestres = Semestre::whereNotIn('id', $planesAvoid)->where('estado', true)->get();

        return response()->json([
            'carrera'       => $carrera,
            'MyPlanes'      => $MyPlanes,
            'semestres'     => $semestres,
        ], 200);
    }

    public function addPlanesCarrera(Request $request){
        $planAcademico = new PlanAcademico();

        $planAcademico->facultad_carrera_id     = $request->facultad_carrera_id;
        $planAcademico->semestre_id             = $request->semestre_id;
        $planAcademico->estado                  = $request->estado;
        
        $planAcademico->save();

        return $this->getCarrerasDetailFacultad($request->facultad_id);
    }

    public function updatePlanesCarrera($id, Request $request){
        $planAcademico = PlanAcademico::findOrFail($id);

        $planAcademico->semestre_id             = $request->semestre_id;
        $planAcademico->estado                  = $request->estado;
        
        $planAcademico->save();

        return $this->getCarrerasDetailFacultad($facultadCarrera->facultad_id);
    }

    public function deletePlanesCarrera($id, Request $request){
        $planAcademico = PlanAcademico::findOrFail($id);

        $planAcademico->delete();

        return $this->getCarrerasDetailFacultad($planAcademico->facultad_id);
    }
}
