<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model{

    public $timestamps = false;
    
    protected $table = 'semestres';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
        'estado',
    ];
    
    protected $casts = [
        'estado'  => 'boolean',
    ];

}
