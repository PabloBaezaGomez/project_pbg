<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'equipment_id';

    public function users()
    {
        return $this->belongsToMany(User::class, 'equipment_user', 'equipment_id', 'user_id');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_equipment', 'equipment_id', 'material_id')
                    ->withPivot('required_quantity');
    }

    public function type()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type', 'equipment_type_id');
    }
}
