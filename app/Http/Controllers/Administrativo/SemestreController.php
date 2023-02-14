<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Semestre;

class SemestreController extends Controller
{
    public function index(){

        $semestres  = Semestre::all();

        return response()->json($semestres);
    }

    public function show($id){

        $semestre = Semestre::findOrFail($id);

        return response()->json([
            'semestre'  => $semestre,
        ]);

    }

    public function create(Request $request){

        $semestre = new Semestre();
        $semestre->nombre       = $request->nombre;
        $semestre->estado       = $request->estado;
        $semestre->inicio       = $request->inicio;
        $semestre->fin          = $request->fin;

        $semestre->save();

        return response()->json($semestre, 200);
    }

    public function update($id, Request $request){
        $semestre = Semestre::findOrFail($id);

        $semestre->nombre       = $request->nombre;
        $semestre->estado       = $request->estado;
        $semestre->inicio       = $request->inicio;
        $semestre->fin          = $request->fin;

        $semestre->save();

        return response()->json($semestre, 200);
    }

    public function destroy($id){
        $data = Semestre::findOrFail($id);
        $data->delete();

        return $this->index();
    }
}
