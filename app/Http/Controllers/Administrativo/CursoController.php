<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use App\Models\Administrativo\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(){
        $cursos  = Curso::all();

        return response()->json($cursos, 200);
    }

    public function show($id){

        $curso = Curso::findOrFail($id);

        return response()->json([
            'curso'  => $curso,
        ]);
    }

    public function create(Request $request){

        $curso = new Curso();
        $curso->nombre       = $request->nombre;
        $curso->tipo       = $request->nombre;
        $curso->estado       = $request->estado;

        $curso->save();

        return response()->json($curso, 200);
    }

    public function update($id, Request $request){
        $curso = Curso::findOrFail($id);

        $curso->nombre        = $request->nombre;
        $curso->tipo          = $request->codigo;
        $curso->estado        = $request->estado;

        $curso->save();

        return response()->json($curso, 200);
    }

    public function destroy($id){
        $data = Curso::findOrFail($id);
        $data->delete();

        return $this->index();
    }
}
