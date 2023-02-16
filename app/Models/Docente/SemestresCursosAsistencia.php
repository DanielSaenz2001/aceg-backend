<?php

namespace App\Models\Docente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemestresCursosAsistencia extends Model
{
    public $timestamps = false;
    
    protected $table = 'semestres_cursos_asistencias';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'semestres_curso_id',
        'alumno_id',
        'fecha',
        'estado',
    ];
    
    protected $casts = [
        'semestres_curso_id'    => 'integer',
        'alumno_id'             => 'integer',
        'estado'                => 'integer',
    ];
}
