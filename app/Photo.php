<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\SubCategory;
use App\VersionPhoto;

class Photo extends Model
{

    protected $fillable = [

        'EK-price',
        'image',
        'status',
        'title',
        'small_thumbnail',
        'singleImage',
        'original_image',
        'description',
        'sub_category_id',
        'category_id',
        'originalResized',
        'EK_year',
        'EK_price',
        'image_year ',
        'photographer',
        'color_create_version',
        'image_name',
        'counter',
        'OF_height',
        'OF_width',
        'weather',
        'season',
        'type',
        'original_filename',
        'category_id_2',
        'sub_category_id_2',
        'category_id_3',
        'sub_category_id_3',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }

    public static function deleteLogo($id)
    {
        return Photo::find($id)->delete();
    }

    public function getVersions()
    {
        return $this->hasMany(VersionPhoto::class, 'photo_id', 'id');
    }
}
