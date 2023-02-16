<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matricula\SemestresCurso;
use App\Models\Matricula\SemestresCursosAlumno;

class DCursosController extends Controller
{
    
    public function getCursos(){
        $cursos = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->join('plan_periodos', 'plan_periodos.id', 'plan_cursos.plan_periodo_id')
        ->join('plan_academico', 'plan_academico.id', 'plan_periodos.plan_academico_id')
        ->join('facultades_carreras', 'facultades_carreras.id', 'plan_academico.facultad_carrera_id')
        ->join('carreras', 'carreras.id', 'facultades_carreras.carrera_id')
        ->where('semestres_cursos.docente_id', auth()->user()->id)
        ->where('semestres.estado', true)
        ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
        , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica'
        , 'semestres_cursos.grupo', 'plan_periodos.periodo', 'carreras.nombre as carrera')
        ->orderBy('periodo', 'ASC')->orderBy('grupo', 'ASC')->orderBy('nombre', 'ASC')->get();
        
        return response()->json($cursos, 200);
    }

    public function getAlumnos($id){
        $curso  = SemestresCurso::join('semestres', 'semestres.id', 'semestres_cursos.semestre_id')
        ->join('plan_cursos', 'plan_cursos.id', 'semestres_cursos.plan_curso_id')
        ->join('cursos', 'cursos.id', 'plan_cursos.curso_id')
        ->where('semestres_cursos.docente_id', auth()->user()->id)
        ->where('semestres_cursos.id', $id)
        ->select('semestres_cursos.id', 'cursos.nombre', 'plan_cursos.creditos'
        , 'plan_cursos.hora_teorica', 'plan_cursos.hora_practica', 'semestres_cursos.grupo')->first();
        
        $alumnos = SemestresCursosAlumno::join('users', 'users.id', 'semestres_cursos_alumnos.alum_id')
        ->select('users.id as user_id', 'users.nombres', 'users.apellido_paterno', 'users.apellido_materno')
        ->where('semestres_cursos_alumnos.estado', 1)
        ->where('semestres_cursos_alumnos.sem_cur_id', $id)->get();

        return response()->json([
            'curso'   => $curso,
            'alumnos' => $alumnos
        ], 200);
    }
}
