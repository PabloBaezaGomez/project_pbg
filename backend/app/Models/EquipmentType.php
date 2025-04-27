<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'equipment_type_id';

    /**
     * Get the equipment that belong to this type.
     */
    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'equipment_type', 'equipment_type_id');
    }
}