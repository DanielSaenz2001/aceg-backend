<?php

namespace App\Models\Matricula;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemestresPlan extends Model
{
    public $timestamps = false;
    
    protected $table = 'semestres_planes';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'plan_academico_id',
        'semestre_id',
    ];
    
    protected $casts = [
        'plan_academico_id' => 'integer',
        'semestre_id'       => 'integer',
    ];
}
