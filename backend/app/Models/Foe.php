<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foe extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $primaryKey = 'foe_id';

    protected $fillable = [
        'foe_name',
        'foe_type',
        'foe_size',
        'foe_description',
        'foe_icon',
        'foe_image'
    ];

    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */

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
