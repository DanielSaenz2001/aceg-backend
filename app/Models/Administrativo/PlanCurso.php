<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanCurso extends Model{

    public $timestamps = false;
    
    protected $table = 'plan_cursos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'plan_periodo_id',
        'curso_id',
        'creditos',
        'hora_teorica',
        'hora_practica',
        'nota_minima',
    ];
    
    protected $casts = [
        'creditos'      => 'integer',
        'hora_practica' => 'integer',
        'hora_teorica'  => 'integer',
        'nota_minima'   => 'integer',
        'plan_periodo_id' => 'integer',
        'curso_id' => 'integer',
    ];
}
