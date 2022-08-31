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
    public function getById($id) {
        $permiso  = Permiso::FindOrFail($id);

        return response()->json($permiso); 
    }
    public function create(Request $request) {
        $permiso       = new Permiso();

        $permiso->nombre     =  $request->nombre;
        $permiso->codigo     =  $request->codigo;
        $permiso->activo     =  true;
        $permiso->save();

        return $this->index();
    }

    public function update($id, Request $request) {
        $permiso  = Permiso::findOrFail($id);

        $permiso->nombre     =  $request->nombre;
        $permiso->activo     =  $request->activo;
        $permiso->save();

        return $this->index();
    }

    public function destroy($id) {
        $permiso   = Permiso::FindOrFail($id);
        $permiso->delete();

        return $this->index();
    }
}
