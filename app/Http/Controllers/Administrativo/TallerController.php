<?php

namespace App\Http\Controllers\Administrativo;

use App\Models\Administrativo\Taller;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    
    public function index(){
        $talleres  = Taller::all();

        return response()->json($talleres, 200);
    }

    public function show($id){

        $taller = Taller::findOrFail($id);

        return response()->json([
            'taller'  => $taller,
        ]);
    }

    public function create(Request $request){

        $taller = new Taller();

        $taller->nombre          = $request->nombre;
        $taller->tipo            = $request->nombre;
        $taller->descripcion     = $request->descripcion;
        $taller->estado          = $request->estado;

        $taller->save();

        return response()->json($taller, 200);
    }

    public function update($id, Request $request){
        $taller = Taller::findOrFail($id);

        $taller->nombre          = $request->nombre;
        $taller->tipo            = $request->nombre;
        $taller->descripcion     = $request->descripcion;
        $taller->estado          = $request->estado;

        $taller->save();

        return response()->json($taller, 200);
    }

    public function destroy($id){
        $data = Taller::findOrFail($id);
        $data->delete();

        return $this->index();
    }
}
