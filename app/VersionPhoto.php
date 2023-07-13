<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class VersionPhoto extends Model
{

    protected $fillable = [
        'price',
        'image',
        'status',
        'small_thumbnail',
        'singleImage',
        'original_image',
        'description',
        'photo_id',
        'originalResized',
        'image_name',
        'counter',
        'color_create_version',
        'type',
        'EK_year',
        'EK_price',
        'image_year ',
        'photographer',
        'OF_height',
        'OF_width',
        'weather',
        'season',
        'color_select',
        'original_filename',
        'category_id',
        'sub_category_id',
        'category_id_2',
        'sub_category_id_2',
        'category_id_3',
        'sub_category_id_3',
        'title',

    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id', 'id');
    }

    public static function deleteLogo($id)
    {
        return VersionPhoto::find($id)->delete();
    }

    public static function versionPhoto(Request $request, $data)
    {

        $version_photo                       =    new VersionPhoto();
        $version_photo->status               =    $request->status;
        $version_photo->description          =    $request->description;
        $version_photo->color_create_version =    $request->color_create_version;
        $version_photo->photo_id             =    $request->photo_id;
        $version_photo->type                 =    $request->type;
        $version_photo->EK_year              =    $request->EK_year;
        $version_photo->EK_price             =    $request->EK_price;
        $version_photo->image_year           =    $request->image_year;
        $version_photo->photographer         =    $request->photographer;
        $version_photo->OF_height            =    $request->OF_height;
        $version_photo->OF_width             =    $request->OF_width;
        $version_photo->weather              =    $request->weather;
        $version_photo->season               =    $request->season;
        $version_photo->color_select         =    $request->color_select;
        $version_photo->price                =    $request->price;
        $version_photo->title               =     $request->title;


        $version_photo->image                =    $data['image'];
        $version_photo->small_thumbnail      =    $data['small_thumbnail'];
        $version_photo->original_image       =    $data['original_image'];
        $version_photo->original_filename    =    $data['original_filename'];
        $version_photo->status               =    $data['status'];
        $version_photo->singleImage          =    $data['singleImage'];


        $photo_counter = $request->counter;

        $last_version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', $request->color_create_version)
        ->orderBy('counter', 'desc')->first();

        if(!$last_version_photo){
            $counter = 1;
            $version_photo->counter = $counter;

        } else {
            $version_photo->counter = $last_version_photo->counter + 1;
        }

        if($version_photo->counter < 10){
            $version_photo->counter = '0'.$version_photo->counter;
        }

        $version_photo->image_name = 'nzphotos-'.$version_photo->color_create_version.$request->photo_id.$version_photo->counter.'-original.jpg';

        return $version_photo->save() ? $version_photo : false;
    }

}
