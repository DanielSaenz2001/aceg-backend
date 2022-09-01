<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PermisoUser;
use App\Models\Admin\Permiso;
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

        $permisosUsuarios = PermisoUser::join('permisos', 'permisos.id', 'permiso_users.permiso_id')
        ->where('permiso_users.user_id', $id)
        ->select('permisos.*')->get();

        $permisosAvoid = [];

        for ($i=0; $i < count($permisosUsuarios); $i++) { 
            $permisosAvoid[$i] = $permisosUsuarios[$i]['id'];
        }

        $permisos = Permiso::whereNotIn('id', $permisosAvoid)->where('activo', true)->get();


        return response()->json([
            'user'  => $usuario,
            'puser' => $permisosUsuarios,
            'permi' => $permisos
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
        if($usuario->usuario !== $request->usuario){
            $res = User::user($request->usuario)->first();
            if($res){
                return response()->json(array(
                    'code'      =>  400,
                    'error' => 'Error en Respuesta',
                    'message'   =>  "Ya hay un Usuario registrado."
                ), 400);
            }
        }
        if($usuario->email !== $request->email){
            $res = User::email($request->email)->first();
            if($res){
                return response()->json(array(
                    'code'      =>  400,
                    'error' => 'Error en Respuesta',
                    'message'   =>  "Ya hay un Usuario registrado con ese correo."
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
        $usuario->validado          = $request->validado;
        $usuario->imagen            = $request->imagen;
        $usuario->usuario           = $request->usuario;
        $usuario->modificado        = $mytime;
        $usuario->save();
        
        return response()->json(array(
            'code'      => 200,
            'data'      => 'Ok',
            'message'   => "Usuario Actualizado."
        ), 200);
    }

    public function estado($id){

        $usuario = User::findOrFail($id);

        $usuario->validado = !$usuario->validado;

        $usuario->save();

        return response()->json($usuario);
    }

    /* Users Others */
    
    public function updateFoto($id, Request $request){

        $user = User::findOrFail($id);

        $user->imagen = $request->imagen;

        $user->save();

        return response()->json($user, 200);
    }

    public function recoveryPassword($id){
        $usuario = User::findOrFail($id);

     
        $usuario->validado          = true;
        $usuario->password          = Hash::make('123456');
        $usuario->save();
        
        return response()->json(array(
            'code'      =>  200,
            'data'      => 'Ok',
            'message'   =>  "Usuario Actualizado."
        ), 200);
    }

    /* Users Permisos */

    public function addPermiso($id_user, $id_permiso){
        $puser  = new PermisoUser();

        $puser->permiso_id  = $id_permiso;
        $puser->user_id     = $id_user;
        $puser->save();

        return $this->show($id_user);
    }

    public function deletePermiso($id_user, $id_permiso){
        $puser  = PermisoUser::where('user_id', $id_user)->where('permiso_id', $id_permiso)->first();
        if($puser){
            $puser->delete();
        }else{
            return response()->json([
                'status'    => 'Sin Coincidencia',
                'message'   => 'No se encontro ese registro.'
            ], 404);
        }

        return $this->show($id_user);
    }
}
