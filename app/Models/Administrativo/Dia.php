<?php

namespace App\Models\Administrativo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{

    public $timestamps = false;
    
    protected $table = 'dias';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
    ];
    
    protected $casts = [
    ];
}
