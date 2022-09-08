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
use App\Models\Administrativo\PlanPeriodo;
use App\Models\Administrativo\PlanCurso;

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

        return $this->getCarrerasDetailFacultad($request->sede_facultad_id);
    }

    public function updateCarrerasFacultad($id, Request $request){
        $facultadCarrera = FacultadesCarreras::findOrFail($id);

        $facultadCarrera->carrera_id          = $request->carrera_id;
        $facultadCarrera->estado              = $request->estado;
        
        $facultadCarrera->save();

        return $this->getCarrerasDetailFacultad($facultadCarrera->sede_facultad_id);
    }

    public function deleteCarrerasFacultad($id, Request $request){
        $facultadCarrera = FacultadesCarreras::findOrFail($id);

        $facultadCarrera->delete();

        return $this->getCarrerasDetailFacultad($facultadCarrera->sede_facultad_id);
    }

    public function getPlanesDetailCarrera($carrera_id){
        $carrera        = Carrera::findOrFail($carrera_id);

        $MyPlanes  = PlanAcademico::join('semestres', 'semestres.id', 'plan_academico.semestre_id')
        ->where('plan_academico.facultad_carrera_id', $carrera_id)
        ->select('semestres.*', 'plan_academico.semestre_id as sede_facul_semestre_id'
        , 'plan_academico.facultad_carrera_id as sede_facul_facultad_carrera_id', 'plan_academico.id as sede_facul_id'
        , 'plan_academico.estado as sede_facul_estado')->orderBy('semestres.semestre', 'ASC')->get();

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

        return $this->getCarrerasDetailFacultad($request->facultad_carrera_id);
    }

    public function updatePlanesCarrera($id, Request $request){
        $planAcademico = PlanAcademico::findOrFail($id);

        $planAcademico->semestre_id             = $request->semestre_id;
        $planAcademico->estado                  = $request->estado;
        
        $planAcademico->save();

        return $this->getCarrerasDetailFacultad($facultadCarrera->facultad_carrera_id);
    }

    public function deletePlanesCarrera($id, Request $request){
        $planAcademico = PlanAcademico::findOrFail($id);

        $planAcademico->delete();

        return $this->getCarrerasDetailFacultad($planAcademico->facultad_carrera_id);
    }

    public function getPeriodosDetailPlan($plan_id){
        $plan        = PlanAcademico::findOrFail($plan_id);

        $MyPeriodos  = PlanPeriodo::where('plan_academico_id', $plan_id)
        ->orderBy('periodo', 'ASC')->get();

        foreach ($MyPeriodos as $periodo) {
            $periodo->cursos = PlanCurso::join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->where('plan_cursos.plan_periodo_id', $periodo->id)
            ->select('cursos.*', 'plan_cursos.id as pl_curs_id', 'plan_cursos.plan_periodo_id as pl_curs_plan_periodo_id',
            'plan_cursos.curso_id as pl_curs_curso_id', 'plan_cursos.creditos as pl_curs_creditos', 
            'plan_cursos.hora_teorica as pl_curs_hora_teorica', 'plan_cursos.hora_practica as pl_curs_hora_practica', 
            'plan_cursos.nota_minima as pl_curs_nota_minima')
            ->orderBy('cursos.nombre', 'ASC')->get();
        }

        return response()->json([
            'plan'          => $plan,
            'MyPeriodos'    => $MyPeriodos,
        ], 200);
    }

    public function addPeriodosplan(Request $request){
        $planPeriodo = new PlanPeriodo();

        $planPeriodo->plan_academico_id     = $request->plan_academico_id;
        $planPeriodo->periodo               = $request->periodo;
        
        $planPeriodo->save();

        return $this->getPeriodosDetailPlan($request->plan_academico_id);
    }

    public function updatePeriodosplan($id, Request $request){
        $planPeriodo = PlanPeriodo::findOrFail($id);

        $planPeriodo->periodo               = $request->periodo;
        
        $planPeriodo->save();

        return $this->getPeriodosDetailPlan($facultadCarrera->plan_academico_id);
    }

    public function deletePeriodosplan($id, Request $request){
        $planPeriodo = PlanPeriodo::findOrFail($id);

        $planPeriodo->delete();

        return $this->getPeriodosDetailPlan($planPeriodo->plan_academico_id);
    }
}
