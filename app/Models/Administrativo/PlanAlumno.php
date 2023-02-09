<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAlumno extends Model
{
    public $timestamps = false;
    
    protected $table = 'plan_alumnos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'alumno_id',
        'plan_academico_id',
        'anio',
        'estado',
    ];
    
    protected $casts = [
        'plan_academico_id' => 'integer',
        'alumno_id' => 'integer',
        'cursos_aprobado' => 'integer',
        'cursos_desaprobado' => 'integer',
        'creditos_aprobado' => 'integer',
        'creditos_desaprobado' => 'integer',
        'estado' => 'boolean',
    ];
}
