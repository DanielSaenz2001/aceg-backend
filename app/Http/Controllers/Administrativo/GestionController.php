<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function getSedes(){
        $sedes  = Sede::all();

        return response()->json($sedes);
    }
}
