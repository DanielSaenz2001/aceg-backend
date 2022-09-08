<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPeriodo extends Model{

    public $timestamps = false;
    
    protected $table = 'plan_periodos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'periodo',
        'plan_academico_id',
    ];
    
    protected $casts = [
        'periodo'           => 'integer',
        'plan_academico_id' => 'integer',
    ];
}
