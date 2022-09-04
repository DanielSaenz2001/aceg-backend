<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model{

    public $timestamps = false;
    
    protected $table = 'facultades';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
        'codigo',
        'estado',
    ];
    
    protected $casts = [
        'estado'  => 'boolean',
    ];
}
