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
        'estado',
        'semestre_id',
        'carrera_id',
    ];
    
    protected $casts = [
        'estado'     => 'boolean',
        'carrera_id' => 'integer',
        'carrera_id' => 'integer',
    ];
}
