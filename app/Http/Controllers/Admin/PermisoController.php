<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permiso;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermisoController extends Controller
{
    public function index() {
        $permisos  = Permiso::all();

        return response()->json($permisos);
    }
    public function show($id) {
        $permiso  = Permiso::FindOrFail($id);

        return response()->json($permiso);
    }
    public function create(Request $request) {
        $permiso       = new Permiso();

        $res = Permiso::codigo($request->codigo)->first();
        if($res){
            return response()->json(array(
                'status'    => 'Error en Respuesta',
                'message'   => "Ya hay un Codigo registrado."
            ), 400);
        }

        $permiso->nombre     =  $request->nombre;
        $permiso->codigo     =  $request->codigo;
        $permiso->activo     =  true;
        $permiso->save();

        return response()->json($permiso, 200);
    }

    public function update($id, Request $request) {
        $permiso  = Permiso::findOrFail($id);

        if($permiso->codigo !== $request->codigo){
            $res = Permiso::codigo($request->codigo)->first();
            if($res){
                return response()->json(array(
                    'status'    => 'Error en Respuesta',
                    'message'   => "Ya hay un Codigo registrado."
                ), 400);
            }
        }

        $permiso->nombre     =  $request->nombre;
        $permiso->codigo     =  $request->codigo;
        $permiso->activo     =  $request->activo;
        $permiso->save();

        return response()->json($permiso, 200);
    }

    public function destroy($id) {
        $permiso   = Permiso::FindOrFail($id);
        $permiso->delete();

        return $this->index();
    }
}
