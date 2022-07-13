<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [

        'name',
        'image',
        'status',
        'image_singlePage',
        'image_title',
        'image_price',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
