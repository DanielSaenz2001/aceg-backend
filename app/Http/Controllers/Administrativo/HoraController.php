<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrativo\Hora;

class HoraController extends Controller
{
    public function index(){

        $horas  = Hora::all();

        return response()->json($horas);
    }

    public function show($id){

        $hora = Hora::findOrFail($id);

        return response()->json([
            'hora'  => $hora,
        ]);

    }

    public function create(Request $request){

        $hora = new Hora();
        $hora->hora_inicio      = $request->hora_inicio;
        $hora->hora_fin         = $request->hora_fin;
        $hora->bloque           = $request->bloque;
        $hora->estado           = $request->estado;

        $hora->save();

        return response()->json($hora, 200);
    }

    public function update($id, Request $request){
        $hora = Hora::findOrFail($id);

        $hora->hora_inicio      = $request->hora_inicio;
        $hora->hora_fin         = $request->hora_fin;
        $hora->bloque           = $request->bloque;
        $hora->estado           = $request->estado;

        $hora->save();

        return response()->json($hora, 200);
    }

    public function destroy($id){
        $data = Hora::findOrFail($id);
        $data->delete();

        return $this->index();
    }
}
