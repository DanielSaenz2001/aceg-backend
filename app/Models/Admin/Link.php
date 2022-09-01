<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public $timestamps = false;

    protected $table = 'links';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'nombre',
        'link',
        'icon',
        'visible',
        'orden',
        'padre_id'
    ];
    
    protected $casts = [
        'orden'     => 'integer',
        'padre_id'  => 'integer',
        'visible'   => 'boolean',
    ];
}
