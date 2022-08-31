<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Data\ModuleData;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request){   
        $credentials = request(['usuario', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'Autorización',
                'message' => 'El Usuario o la contraseña estan erroneos.'
            ], 401);
        }
        
        if(auth()->user()->estado == 0 || auth()->user()->estado == false){
            return response()->json([
                'status' => 'Autorización',
                'message' => 'El Usuario no esta autorizado en usar este sistema.'
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    public function cambiarContra(Request $request){
        if(auth()->user()->usuario !== request('usuario')){

            return response()->json([
                'status' => 'Autorización',
                'message' => 'Usted no es propietario de esta cuenta.'
            ], 401);

        }
        $credentials = request(['usuario','password']);
        if(auth()->user()->estado == 0 || auth()->user()->estado == false){

            return response()->json([
                'status' => 'Autorización',
                'message' => 'El Correo no esta autorizado para usar este sistema.'
            ], 401);

        }
        if($token = auth()->attempt($credentials)){
            if($request->password_new == $request->password_confirmation){

                $user = User::where('dni',auth()->user()->dni)->first();
                $user->update(['password'=>$request->password_new]);

                return response()->json([
                    'status' => 'Ok',
                    'message' => 'La contraseña fue cambiada exitosamente.'
                ], 201);
            }
            return response()->json([
                'status' => 'Autorización',
                'message'=>'La contraseñas no coinciden.'
            ],401);
        }

        return response()->json([
            'status' => 'Autorización',
            'message'=>'El Correo o la contraseña estan erroneos.'
        ],401);
    }

    public function me(){
        return response()->json(auth()->user());
    }
    
    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message' => 'Se cerro sesión correctamente.'],200);
    }

    protected function respondWithToken($token){
        $permisos = ModuleData::getModules(auth()->user()->id);

        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'Bearer',
            'expires_in'    => auth()->factory()->getTTL()." minutos",
            'nombreCon'     => auth()->user()->nombres ." ".auth()->user()->apellido_paterno ." ".auth()->user()->apellido_materno,
            'dni'           => auth()->user()->dni,
            'usuario'       => auth()->user()->usuario,
            'permisos'      => $permisos
        ],200);

    }

    protected function jsonResponse($data, $code = 200){
        return response()->json($data, $code,
        ['Content-Type' => 'application/json;charset=UTF8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);

    }
}