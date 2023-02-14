<?php

namespace App\Models\Matricula;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    public $timestamps = false;
    
    protected $table = 'matriculas';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'alumno_id',
        'semestre_id',
        'plan_id',
        'fecha_inicio',
        'estado',
    ];
    
    protected $casts = [
        'alumno_id'         => 'integer',
        'semestre_id'       => 'integer',
        'plan_id'           => 'integer',
    ];
}
