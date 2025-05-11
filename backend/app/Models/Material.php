<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Material extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'material_name',
        'material_description',
        'material_rarity',
        'material_type',
        'created_at',
        'updated_at'
    ];

    protected $guarded = [];

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
            ->withPivot('drop_rate')
            ->withTimestamps();
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'material_equipment', 'material_id', 'equipment_id')
            ->withPivot('required_quantity');
    }
}
