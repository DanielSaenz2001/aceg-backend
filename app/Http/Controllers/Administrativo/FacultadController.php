<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Facultad;

class FacultadController extends Controller
{
    public function index(){

        $facultades  = Facultad::all();

        return response()->json($facultades);
    }

    public function show($id){

        $facultad = Facultad::findOrFail($id);

        return response()->json([
            'facultad'  => $facultad,
        ]);
    }

    public function create(Request $request){

        $facultad = new Facultad();
        $facultad->nombre       = $request->nombre;
        $facultad->codigo       = $request->codigo;
        $facultad->estado       = $request->estado;

        $facultad->save();

        return response()->json($facultad, 200);
    }

    public function update($id, Request $request){
        $facultad = Facultad::findOrFail($id);

        $facultad->nombre       = $request->nombre;
        $facultad->codigo       = $request->codigo;
        $facultad->estado       = $request->estado;

        $facultad->save();

        return response()->json($facultad, 200);
    }

    public function destroy($id){
        $data = Facultad::findOrFail($id);
        $data->delete();

        return $this->index();
    }
}
