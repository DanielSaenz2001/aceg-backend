<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Sede;
use App\Models\Administrativo\SedesFacultades;
use App\Models\Administrativo\FacultadesCarreras;
use App\Models\Administrativo\PlanAcademico;
use App\Models\Administrativo\PlanPeriodo;
use App\Models\Administrativo\PlanCurso;
use App\Models\Administrativo\Semestre;
use App\Models\Matricula\SemestresCurso;
use App\Models\User;

class MHabilitacionCursosController extends Controller
{

    public function filtro($dni){

        $data = User::join('permiso_users', 'permiso_users.user_id', 'users.id')
        ->join('permisos', 'permisos.id', 'permiso_users.permiso_id')
        ->where('permisos.codigo', 'Docente')
        ->where('users.estado', true)->dni($dni)->get();

        return response()->json($data);

    }

    public function getSedes(){

        $sedes      = Sede::all();
        $semestres  = Semestre::where('estado', true)->where('nombre', 'LIKE' , '%'.date("Y").'%')->get();

        $docentes = User::join('permiso_users', 'permiso_users.user_id', 'users.id')
        ->join('permisos', 'permisos.id', 'permiso_users.permiso_id')
        ->where('permisos.codigo', 'Docente')->where('users.estado', true)->get();

        return response()->json([
            'sedes'     => $sedes,
            'semestres' => $semestres,
            'docentes'  => $docentes,
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

    public function getPeriodos($plan_id, $semestre_id){

        $periodos  = PlanPeriodo::where('plan_academico_id', $plan_id)
        ->orderBy('periodo', 'ASC')->get();


        foreach ($periodos as $periodo) {
            $periodo->cursos = PlanCurso::join('cursos', 'cursos.id', 'plan_cursos.curso_id')
            ->where('plan_cursos.plan_periodo_id', $periodo->id)
            ->select('cursos.*', 'plan_cursos.id as pl_curs_id', 'plan_cursos.plan_periodo_id as pl_curs_plan_periodo_id',
            'plan_cursos.curso_id as pl_curs_curso_id', 'plan_cursos.creditos as pl_curs_creditos', 
            'plan_cursos.hora_teorica as pl_curs_hora_teorica', 'plan_cursos.hora_practica as pl_curs_hora_practica', 
            'plan_cursos.nota_minima as pl_curs_nota_minima')
            ->orderBy('cursos.nombre', 'ASC')->get();

            foreach ($periodo->cursos as $curso) {
                $semestre_curso = SemestresCurso::where('semestre_id', $semestre_id)
                ->where('plan_curso_id', $curso->pl_curs_id)->orderBy('grupo', 'ASC')->get();

                $curso->semestre_curso = $semestre_curso;
            }
        }

        return response()->json($periodos, 200);
    }
    
    public function create(Request $request, $plan_id){

        $data = new SemestresCurso();
        $data->plan_id          = $request->plan_id;
        $data->plan_curso_id    = $request->plan_curso_id;
        $data->semestre_id      = $request->semestre_id;
        $data->docente_id       = $request->docente_id;
        $data->cupos            = $request->cupos;
        $data->grupo            = $request->grupo;

        $data->save();
        
        return $this->getPeriodos($plan_id, $request->semestre_id);
    }

    public function update($id, Request $request, $plan_id){

        $data = SemestresCurso::findOrFail($id);
        $data->cupos            = $request->cupos;
        $data->grupo            = $request->grupo;
        $data->save();

        return response()->json($data, 200);
    }
    
    public function getById($id){

        $data = SemestresCurso::findOrFail($id);
        $detail = null;

        if($data->docente_id !== null) {
            $detail = User::findOrFail($data->docente_id);
        }
        
        return response()->json([
            'gestion'   => $data,
            'detail'    => $detail
        ], 200);
    }

    public function destroy($id, $plan_id, $semestre_id){

        $data = SemestresCurso::findOrFail($id);
        $data->delete();

        return $this->getPeriodos($plan_id, $semestre_id);
    }

    public function changeDocente($id, $curso_id){
        $user = User::findOrFail($id);

        $data = SemestresCurso::findOrFail($curso_id);
        $data->docente_id       = $id;
        $data->save();
        
        return response()->json($user, 200);
    }
}
