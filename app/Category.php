<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{


    protected $fillable = [

        'name',
        'status',
        'image',
        'sort',
    ];

    public function subcategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public static function getLastSortNumber()
    {
        $leastSortRecords = Category::orderBy('sort', 'desc')->first();
        return $leastSortRecords->sort;
    }
}
