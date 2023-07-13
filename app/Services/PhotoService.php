<?php

namespace App\Services;
use Intervention\Image\Facades\Image;

class PhotoService
{
    public function imagesFolder($request, $imagePath, $width, $height, $time, $versionCounter, $photo_id = null)
    {
        if($width != null && $height != null) {
            $image                  = $request->file('image');
            if($photo_id) {
                $imageName              =  'nzphotos-' . $request->color_create_version . $photo_id. $versionCounter.'-'.$width.'x'.$height.'.jpg';
            } elseif($request->photo_id) {
                $imageName              =  'nzphotos-' . $request->color_create_version . $request->photo_id. $versionCounter.'-'.$width.'x'.$height.'.jpg';
            } elseif($request->color_create_version) {
                $imageName              =  'nzphotos-' . $request->color_create_version . $request->id .'-'.$width.'x'.$height.'.jpg';
            }  else {
                $imageName              =  'nzphotos-' . $request->id .'-'.$width.'x'.$height.'.jpg';
            }

            $imgFileCollection      = Image::make($image->getRealPath());       //image resize from here;
            $imgFileCollection->resize($width, $height, function($constraint)
            {
                $constraint->aspectRatio();

            });

            $pathOfImage            = public_path() . $imagePath;
            $imgFileCollection->save($pathOfImage . $imageName);
            } else {
                $image                  = $request->file('image');
                if($photo_id) {
                    $imageName              =  'nzphotos-' . $request->color_create_version . $photo_id. $versionCounter.'-original.jpg';
                } elseif($request->photo_id) {
                    $imageName              =  'nzphotos-' . $request->color_create_version . $request->photo_id. $versionCounter.'-original.jpg';
                } else {
                    $imageName              =  'nzphotos-' . $request->color_create_version .'-original.jpg';
                }

                $imgFileCollection      = Image::make($image->getRealPath());       //image resize from here;

                $pathOfImage    = public_path() . $imagePath;
                $imgFileCollection->save($pathOfImage . $imageName);
            }


            return $imageName;
    }


}

?>
