<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialUser extends Model
{
    protected $table = 'material_user';
    protected $fillable = ['user_id', 'material_id', 'quantity'];

    public $incrementing = false;
    protected $primaryKey = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}