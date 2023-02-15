<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PermisoUser;
use App\Models\User;
use App\Models\Admin\Permiso;
use Carbon\Carbon;

class MatriculaAdminController extends Controller
{
    public function create(Request $request){
        $mytime = Carbon::now();

        $res = User::dni($request->dni)->first();
        if($res){
            return response()->json(array(
                'code'      =>  400,
                'error' => 'Error en Respuesta',
                'message'   =>  "Ya hay un Usuario registrado con ese dni."
            ), 400);
        }

        $res = User::user($request->usuario)->first();
        if($res){
            return response()->json(array(
                'code'      =>  400,
                'error' => 'Error en Respuesta',
                'message'   =>  "Ya hay un Usuario registrado."
            ), 400);
        }

        $res = User::email($request->email)->first();
        if($res){
            return response()->json(array(
                'code'      =>  400,
                'error' => 'Error en Respuesta',
                'message'   =>  "Ya hay un Usuario registrado con ese correo."
            ), 400);
        }
        
        $usuario = new User();
        $usuario->nombres           = $request->nombres;
        $usuario->apellido_paterno  = $request->apellido_paterno;
        $usuario->apellido_materno  = $request->apellido_materno;
        $usuario->direccion         = $request->direccion;
        $usuario->dni               = $request->dni;
        $usuario->sexo              = $request->sexo;
        $usuario->email             = $request->email;
        $usuario->fecha_nacimiento  = $request->fecha_nacimiento;
        $usuario->celular           = $request->celular;
        $usuario->usuario           = $request->usuario;
        $usuario->password          = $request->dni;
        $usuario->estado            = true;
        $usuario->creado            = $mytime;
        $usuario->modificado        = $mytime;
        $usuario->imagen            = $request->imagen;

        $usuario->save();

        $pemiso = Permiso::where('codigo', 'Alumno')->first();

        $puser  = new PermisoUser();
        $puser->permiso_id  = $pemiso->id;
        $puser->user_id     = $usuario->id;
        $puser->save();

        $pemiso = Permiso::where('codigo', 'MAlumno')->first();

        $puser  = new PermisoUser();
        $puser->permiso_id  = $pemiso->id;
        $puser->user_id     = $usuario->id;
        $puser->save();

        return response()->json(array(
            'code'      =>  200,
            'data'      => 'Ok',
            'message'   =>  "Usuario creado con exito."
        ), 200);
    }
}
