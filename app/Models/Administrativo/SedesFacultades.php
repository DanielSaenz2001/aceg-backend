<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SedesFacultades extends Model
{

    public $timestamps = false;
    
    protected $table = 'sedes_facultades';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'sede_id',
        'facultad_id',
    ];
    
    protected $casts = [
        'sede_id'       => 'integer',
        'facultad_id'   => 'integer',
    ];
}
