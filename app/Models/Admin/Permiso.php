<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    public $timestamps = false;

    protected $table = 'permisos';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
        'codigo',
        'activo'
    ];
    
    protected $casts = [
        'activo'    => 'boolean',
    ];

    public function scopeCodigo($query, $codigo){
        return $query->where('permisos.codigo','like',"$codigo");
    }
}
