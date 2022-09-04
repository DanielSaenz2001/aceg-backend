<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Sede;

class SedeController extends Controller
{
    public function index(){

        $sedes  = Sede::all();

        return response()->json($sedes);
    }

    public function show($id){

        $sede = Sede::findOrFail($id);

        return response()->json([
            'sede'  => $sede,
        ]);

    }

    public function create(Request $request){

        $sede = new Sede();
        $sede->nombre       = $request->nombre;
        $sede->direccion    = $request->direccion;
        $sede->distrito     = $request->distrito;
        $sede->provincia    = $request->provincia;
        $sede->departamento = $request->departamento;
        $sede->pais         = $request->pais;
        $sede->ubigeo       = $request->ubigeo;
        $sede->codigo       = $request->codigo;
        $sede->estado       = $request->estado;

        $sede->save();

        return response()->json($sede, 200);
    }

    public function update($id, Request $request){
        $sede = Sede::findOrFail($id);

        $sede->nombre       = $request->nombre;
        $sede->direccion    = $request->direccion;
        $sede->distrito     = $request->distrito;
        $sede->provincia    = $request->provincia;
        $sede->departamento = $request->departamento;
        $sede->pais         = $request->pais;
        $sede->ubigeo       = $request->ubigeo;
        $sede->codigo       = $request->codigo;
        $sede->estado       = $request->estado;

        $sede->save();

        return response()->json($sede, 200);
    }

    public function destroy($id){
        $data = Sede::findOrFail($id);
        $data->delete();

        return $this->index();
    }
}
