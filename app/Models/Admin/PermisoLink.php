<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoLink extends Model
{
    public $timestamps = false;

    protected $table = 'permiso_links';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'link_id',
        'permiso_id',
    ];
    
    protected $casts = [
        'permiso_id'    => 'integer',
        'link_id'       => 'integer',
    ];
}
