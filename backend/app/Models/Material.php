<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'material_id';

    public function users()
    {
        return $this->belongsToMany(User::class, 'material_user')
            ->withTimestamps()
            ->withPivot('quantity');
    }

    public function type()
    {
        return $this->belongsTo(MaterialType::class, 'material_type', 'material_type_id');
    }

    public function foes()
    {
        return $this->belongsToMany(Foe::class, 'material_foe', 'material_id', 'foe_id')
            ->withPivot('drop_rate');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'material_equipment', 'material_id', 'equipment_id')
            ->withPivot('required_quantity');
    }
}
