<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'material_type_id';

    /**
     * Get the materials that belong to this type.
     */
    public function materials()
    {
        return $this->hasMany(Material::class, 'material_type', 'material_type_id');
    }
}