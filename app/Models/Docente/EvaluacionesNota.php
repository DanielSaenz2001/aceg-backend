<?php

namespace App\Models\Docente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionesNota extends Model
{
    public $timestamps = false;
    
    protected $table = 'evaluaciones_notas';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'evaluacion_id',
        'alumno_id',
        'nota',
    ];
    
    protected $casts = [
        'semestres_cursos_evaluacion_id'    => 'integer',
        'alumno_id'                         => 'integer',
    ];
}
