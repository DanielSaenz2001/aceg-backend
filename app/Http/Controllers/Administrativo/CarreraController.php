<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Carrera;
use App\Models\Administrativo\Facultad;

class CarreraController extends Controller
{
    public function index(){
        $facultas  = Facultad::all();

        $carreras  = Carrera::join('facultades', 'facultades.id', 'carreras.facultad_id')
        ->select('carreras.id', 'carreras.nombre', 'carreras.codigo', 'carreras.estado'
        , 'carreras.facultad_id','facultades.nombre as facultad')->get();

        return response()->json([
            'carreras' => $carreras,
            'facultas' => $facultas
        ], 200);
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

        $facultas  = Facultad::findOrFail($request->facultad_id);

        $carrera->facultad = $facultas->nombre;

        return response()->json($carrera, 200);
    }

    public function update($id, Request $request){
        $carrera = Carrera::findOrFail($id);

        $carrera->nombre       = $request->nombre;
        $carrera->codigo       = $request->codigo;
        $carrera->estado       = $request->estado;
        $carrera->facultad_id  = $request->facultad_id;

        $carrera->save();

        $facultas  = Facultad::findOrFail($request->facultad_id);

        $carrera->facultad = $facultas->nombre;

        return response()->json($carrera, 200);
    }

    public function destroy($id){
        $data = Carrera::findOrFail($id);
        $data->delete();

        return $this->index();
    }
}
