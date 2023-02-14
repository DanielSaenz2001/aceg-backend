<?php

namespace App\Models\Matricula;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemestresCurso extends Model
{
    public $timestamps = false;
    
    protected $table = 'semestres_cursos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'plan_curso_id',
        'plan_id',
        'semestre_id',
        'cupos',
        'grupo',
    ];
    
    protected $casts = [
        'plan_curso_id'  => 'integer',
        'plan_id'        => 'integer',
        'semestre_id'    => 'integer',
        'docente_id'     => 'integer',
    ];
}
