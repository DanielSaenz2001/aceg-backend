<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{

    public $timestamps = false;
    
    protected $table = 'talleres';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
        'tipo',
        'descripcion',
        'estado',
    ];
    
    protected $casts = [
        'estado'  => 'boolean',
    ];
}
