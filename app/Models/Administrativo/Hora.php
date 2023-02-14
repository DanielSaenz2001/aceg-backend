<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{

    public $timestamps = false;
    
    protected $table = 'horas';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'hora_inicio',
        'hora_fin',
        'bloque',
        'estado'
    ];
    
    protected $casts = [
        'estado'  => 'boolean',
    ];
}
