<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRequisito extends Model
{

    public $timestamps = false;
    
    protected $table = 'plan_requisitos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'plan_curso_id',
        'requisito_id',
    ];
    
    protected $casts = [
        'plan_curso_id' => 'integer',
        'requisito_id'  => 'integer',
    ];
}
