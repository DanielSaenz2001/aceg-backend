<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoUser extends Model
{
    public $timestamps = false;

    protected $table = 'permiso_users';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'user_id',
        'permiso_id',
    ];
    
    protected $casts = [
        'permiso_id'    => 'integer',
        'user_id'       => 'integer',
    ];
}
