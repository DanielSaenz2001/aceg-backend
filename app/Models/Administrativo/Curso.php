<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

    public $timestamps = false;
    
    protected $table = 'cursos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
        'codigo',
        'estado',
        'sumilla',
        'competencia',
    ];
    
    protected $casts = [
        'estado'  => 'boolean',
    ];
}
