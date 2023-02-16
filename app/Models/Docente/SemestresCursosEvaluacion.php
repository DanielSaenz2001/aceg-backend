<?php

namespace App\Models\Docente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemestresCursosEvaluacion extends Model
{
    public $timestamps = false;
    
    protected $table = 'semestres_cursos_evaluaciones';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'semestres_curso_id',
        'nombre',
        'fecha',
        'porcentaje',
    ];
    
    protected $casts = [
        'semestres_curso_id'    => 'integer',
        'porcentaje'            => 'integer',
    ];
}
