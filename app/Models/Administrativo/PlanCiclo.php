<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanCiclo extends Model{

    public $timestamps = false;
    
    protected $table = 'plan_ciclos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'ciclo',
        'plan_academico_id',
    ];
    
    protected $casts = [
        'ciclo'             => 'integer',
        'plan_academico_id' => 'integer',
    ];
}
