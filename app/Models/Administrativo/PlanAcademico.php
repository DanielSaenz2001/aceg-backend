<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAcademico extends Model{

    public $timestamps = false;
    
    protected $table = 'plan_academico';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'semestre_id',
        'facultad_carrera_id',
        'estado',
    ];
    
    protected $casts = [
        'estado'                => 'boolean',
        'semestre_id'           => 'integer',
        'facultad_carrera_id'   => 'integer',
    ];
}
