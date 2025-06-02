<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $timestamps = true; // Enable timestamps instead of false

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_name',
        'user_email',
        'user_password',
        'user_type'
    ];

    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_user', 'user_id', 'equipment_id');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_user', 'user_id', 'material_id')
            ->withPivot('quantity');
    }
}
