<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_name',
        'user_email',
        'user_password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'user_password' => 'hashed',
        ];
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    /**
     * Get the username for the user.
     */
    public function getEmailForAuthentication()
    {
        return $this->user_email;
    }

    /**
     * Get the materials associated with the user
     */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_user', 'user_id', 'material_id')
            ->withTimestamps()
            ->withPivot('quantity');
    }

    /**
     * Get the equipment associated with the user
     */
    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_user', 'user_id', 'equipment_id');
    }
}
