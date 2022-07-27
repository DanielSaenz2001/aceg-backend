<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model{

    public $timestamps = false;
    
    protected $table = 'role_user';
    protected $primaryKey = 'id';
    protected $guarded = ["id"];

    protected $fillable = [
        'id',
        'user_id',
        'rol_id',
    ];
    
    protected $casts = [
        'user_id'     => 'integer',
        'rol_id'      => 'integer',
    ];

    public function scopeUser($query, $user){
        return $query->where('role_user.user_id','like',$user);
    }
    public function scopeRol($query, $rol){
        return $query->where('role_user.rol_id','like',$rol);
    }
}
