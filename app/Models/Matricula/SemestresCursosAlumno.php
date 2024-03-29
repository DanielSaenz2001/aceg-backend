<?php

namespace App\Models\Matricula;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemestresCursosAlumno extends Model
{
    public $timestamps = false;
    
    protected $table = 'semestres_cursos_alumnos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'sem_cur_id',
        'alum_id',
        'matri_id',
        'estado',
    ];
    
    protected $casts = [
        'semestres_curso_id'    => 'integer',
        'alumno_id'             => 'integer',
        'matricula_id'          => 'integer',
        'estado'                => 'integer',
    ];
}
