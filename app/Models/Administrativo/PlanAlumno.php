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
        'estado',
    ];
    
    protected $casts = [
        'plan_academico_id' => 'integer',
        'alumno_id' => 'integer',
        'estado' => 'boolean',
    ];
}
