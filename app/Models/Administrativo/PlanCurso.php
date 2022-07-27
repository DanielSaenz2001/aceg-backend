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
        'nombre',
        'creditos',
        'hora_teorica',
        'hora_practica',
        'nota_minima',
        'sumilla',
        'competencia',
        'plan_ciclo_id',
        'estado',
    ];
    
    protected $casts = [
        'estado'        => 'boolean',
        'creditos'      => 'integer',
        'hora_practica' => 'integer',
        'hora_teorica'  => 'integer',
        'nota_minima'   => 'integer',
        'plan_ciclo_id' => 'integer',
    ];
}
