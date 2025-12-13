<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenitiesCategories extends Model
{
    public $table = 'amenities_categories';

    protected $fillable = [
        'name',
        'status'
    ];

    public function features()
    {
        return $this->hasMany(AmenitiesFeature::class, 'category_id');
    }
}
