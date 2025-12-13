<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenitiesFeature extends Model
{
    
    public $table = 'amenities_features';

    protected $fillable = [
        'category_id',
        'name',
        'status',
        'icon'
    ];

    public function category()
    {
        return $this->belongsTo(AmenitiesCategories::class, 'category_id');
    }
}
