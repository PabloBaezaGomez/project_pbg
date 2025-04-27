<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foe extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'foe_id';

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_foe', 'foe_id', 'material_id')
                    ->withPivot('drop_rate');
    }

    public function type()
    {
        return $this->belongsTo(FoeType::class, 'foe_type', 'foe_type_id');
    }
}
