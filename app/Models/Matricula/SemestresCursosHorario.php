<?php

namespace App\Models\Matricula;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemestresCursosHorario extends Model
{
    public $timestamps = false;
    
    protected $table = 'semestres_cursos_horarios';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'semestres_curso_id',
        'hora_id',
        'dia_id',
    ];
    
    protected $casts = [
        'semestres_curso_id'    => 'integer',
        'hora_id'               => 'integer',
        'dia_id'                => 'integer',
    ];
}
