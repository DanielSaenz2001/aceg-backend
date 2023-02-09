<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAlumnoNota extends Model
{
    public $timestamps = false;
    
    protected $table = 'plan_alumnos_notas';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'plan_alumno_id',
        'plan_curso_id',
        'estado',
    ];
    
    protected $casts = [
        'plan_alumno_id' => 'integer',
        'plan_curso_id' => 'integer',
        'estado' => 'integer',
    ];
}
