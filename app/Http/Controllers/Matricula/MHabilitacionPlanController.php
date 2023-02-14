<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Sede;
use App\Models\Administrativo\SedesFacultades;
use App\Models\Administrativo\FacultadesCarreras;
use App\Models\Administrativo\PlanAcademico;
use App\Models\Administrativo\Semestre;
use App\Models\Matricula\SemestresPlan;

class MHabilitacionPlanController extends Controller
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

    public function getPlanes($carrera_id, $semestre_id){
        $planes  = PlanAcademico::join('semestres', 'semestres.id', 'plan_academico.semestre_id')
        ->where('plan_academico.facultad_carrera_id', $carrera_id)
        ->select('semestres.*', 'plan_academico.id as plan_semes_id')->orderBy('semestres.nombre', 'ASC')->get();

        foreach ($planes as $plan) {
            $plan->habilitado = SemestresPlan::where('plan_academico_id', $plan->plan_semes_id)
            ->where('semestre_id', $semestre_id)->first();
        }

        return response()->json($planes, 200);
    }
    public function create(Request $request, $carrera_id){

        $data = new SemestresPlan();
        $data->plan_academico_id    = $request->plan_academico_id;
        $data->semestre_id          = $request->semestre_id;
        $data->save();
        
        return $this->getPlanes($carrera_id, $data->semestre_id);
    }

    public function destroy($id, $carrera_id){

        $data = SemestresPlan::findOrFail($id);
        $data->delete();

        return $this->getPlanes($carrera_id, $data->semestre_id);
    }
    
}
