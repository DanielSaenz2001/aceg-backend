<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultadesCarreras extends Model
{

    public $timestamps = false;
    
    protected $table = 'facultades_carreras';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'sede_facultad_id',
        'carrera_id',
    ];
    
    protected $casts = [
        'sede_facultad_id'  => 'integer',
        'carrera_id'        => 'integer',
    ];
}
