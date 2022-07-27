<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanUnidad extends Model{

    public $timestamps = false;
    
    protected $table = 'plan_cursos_unidad';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'unidad',
        'descripcion',
        'resultados',
        'plan_curso_id',
    ];
    
    protected $casts = [
        'estado'        => 'boolean',
        'unidad'        => 'integer',
        'plan_curso_id' => 'integer',
    ];
}
