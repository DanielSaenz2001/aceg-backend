<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model{

    public $timestamps = false;
    
    protected $table = 'sedes';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
        'direccion',
        'modalidad',
        'ubigeo',
        'codigo',
        'estado',
    ];

}
