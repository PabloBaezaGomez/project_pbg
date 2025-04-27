<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoeType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'foe_type_id';

    /**
     * Get the foes that belong to this type.
     */
    public function foes()
    {
        return $this->hasMany(Foe::class, 'foe_type', 'foe_type_id');
    }
}