<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Carrera;

class CarreraController extends Controller
{
    public function index(){

        $carreras  = Carrera::all();

        return response()->json($carreras);
    }

    public function show($id){

        $carrera = Carrera::findOrFail($id);

        return response()->json([
            'carrera'  => $carrera,
        ]);
    }

    public function create(Request $request){

        $carrera = new Carrera();
        $carrera->nombre       = $request->nombre;
        $carrera->codigo       = $request->codigo;
        $carrera->estado       = $request->estado;
        $carrera->facultad_id  = $request->facultad_id;

        $carrera->save();

        return response()->json($carrera, 200);
    }

    public function update($id, Request $request){
        $carrera = Carrera::findOrFail($id);

        $carrera->nombre       = $request->nombre;
        $carrera->codigo       = $request->codigo;
        $carrera->estado       = $request->estado;
        $carrera->facultad_id  = $request->facultad_id;

        $carrera->save();

        return response()->json($carrera, 200);
    }

    public function destroy($id){
        $data = Carrera::findOrFail($id);
        $data->delete();

        return $this->index();
    }
}
