<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\RoleUser;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(){

        $resquest  = User::paginate(20);

        return response()->json($resquest); 
    }

    public function show($id){

        $usuario = User::findOrFail($id);

        return response()->json([
            'user' => $usuario
        ]);

    }

    public function filtro(Request $request){

        $usuario = User::paterno($request->paterno)->materno($request->materno)
        ->nombre($request->nombres)->dni($request->dni)->paginate(100);
        
        return response()->json($usuario);

    }
    
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
        $usuario->validado          = true;
        $usuario->creado            = $mytime;
        $usuario->modificado        = $mytime;
        $usuario->validado          = $request->validado;
        $usuario->imagen            = $request->imagen;

        $usuario->save();

        return response()->json(array(
            'code'      =>  200,
            'data'      => 'Ok',
            'message'   =>  "Usuario creado con exito."
        ), 200);
    }

    public function update($id,Request $request){
        $mytime  = Carbon::now();
        $usuario = User::findOrFail($id);

        if($usuario->dni !== $request->dni){
            $res = User::dni($request->dni)->first();
            if($res){
                return response()->json(array(
                    'code'      =>  400,
                    'error' => 'Error en Respuesta',
                    'message'   =>  "Ya hay un Usuario registrado con ese dni."
                ), 400);
            }
        }
        if($usuario->username !== $request->username){
            $res = User::user($request->username)->first();
            if($res){
                return response()->json(array(
                    'code'      =>  400,
                    'error' => 'Error en Respuesta',
                    'message'   =>  "Ya hay un Usuario registrado."
                ), 400);
            }
        }

        $usuario = User::findOrFail($id);
        $usuario->dni               = $request->dni;
        $usuario->nombres           = $request->nombres;
        $usuario->apellido_paterno  = $request->apellido_paterno;
        $usuario->apellido_materno  = $request->apellido_materno;
        $usuario->direccion         = $request->direccion;
        $usuario->sexo              = $request->sexo;
        $usuario->email             = $request->email;
        $usuario->fecha_nacimiento  = $request->fecha_nacimiento;
        $usuario->celular           = $request->celular;
        $usuario->estado            = $request->estado;
        $usuario->imagen            = $request->imagen;
        $usuario->username          = $request->username;
        $usuario->modificado        = $mytime;
        $usuario->save();
        
        return response()->json(array(
            'code'      =>  200,
            'data'      => 'Ok',
            'message'   =>  "Usuario Actualizado."
        ), 200);
    }

    public function estado($id){

        $usuario = User::findOrFail($id);

        $usuario->estado = !$usuario->estado;

        $usuario->save();

        return response()->json($usuario);
    }
    
    public function createRoles(Request $request){

        $mytime = Carbon::now();
        $role    = RoleUser::user($request->id)->rol($request->rol_id)->first();

        if($role){
            return response()->json(array(
                'code'      =>  400,
                'error' => 'Error en Respuesta',
                'message'   =>  "El usuario ya tiene el rol deseado."
            ), 400);
        }

        $rolUser = new RoleUser();
        $rolUser->user_id   = $request->id;
        $rolUser->rol_id    = $request->rol_id;
        $rolUser->created   = $mytime;
        $rolUser->modified  = $mytime;
        $rolUser->username  = auth()->user()->username;
        $rolUser->save();

        $roles   = RoleUser::user($rolUser->user_id)->get();
        return response()->json(array(
            'code'      => 200,
            'data'      => $roles,
            'message'   => "Rol agregado con exito."
        ), 200);
    }

    public function destroyRoles($id){

        $rolUser = RoleUser::findOrFail($id);

        $roles   = RoleUser::user($rolUser->user_id)->get();
        if(count($res) < 2){
            return response()->json(array(
                'code'      =>  400,
                'error' => 'Error en Respuesta',
                'message'   =>  "No puede eliminar mas roles de este usuario."
            ), 400);
        }
        RoleUser::findOrFail($id)->delete();

        return response()->json(array(
            'code'      => 200,
            'data'      => $roles,
            'message'   => "Rol de usuario eliminado."
        ), 200);
    }
    
    public function updateFoto($id, Request $request){

        $user = User::findOrFail($id);

        $user->imagen = $request->imagen;

        $user->save();

        return response()->json($user, 200);
    }

    public function recoveryPassword($id){
        $usuario = User::findOrFail($id);

     
        $usuario->validado          = false;
        $usuario->password          = Hash::make('123456');
        $usuario->save();
        
        return response()->json(array(
            'code'      =>  200,
            'data'      => 'Ok',
            'message'   =>  "Usuario Actualizado."
        ), 200);
    }
}
