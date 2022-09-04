<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model{

    public $timestamps = false;
    
    protected $table = 'carreras';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
        'codigo',
        'estado',
        'facultad_id'
    ];
    
    protected $casts = [
        'estado'      => 'boolean',
    ];

}
