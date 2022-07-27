<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Role;
use Carbon\Carbon;

class RoleController extends Controller{
    public function index() {
        $roles  = Role::all();

        return response()->json($roles);
    }
    public function getById($id) {
        $rol  = Role::FindOrFail($id);

        return response()->json($rol); 
    }
    public function create(Request $request) {
        $mytime   = Carbon::now();
        $role  = new Role();

        $role->nombre     =  $request->nombre;
        $role->codigo     =  $request->codigo;
        $role->usuario    =  auth()->user()->usuario;
        $role->creado     =  $mytime;
        $role->modificado =  $mytime;
        $role->save();

        return $this->index();
    }

    public function update($id, Request $request) {
        $mytime   = Carbon::now();
        $role  = Role::findOrFail($id);

        $role->nombre     =  $request->nombre;
        $role->codigo     =  $request->codigo;
        $role->usuario    =  auth()->user()->usuario;
        $role->modificado =  $mytime;
        $role->save();

        return $this->index();
    }

    public function destroy($id) {
        $role   = Role::FindOrFail($id);
        $role->delete();

        return $this->index();
    }

}
