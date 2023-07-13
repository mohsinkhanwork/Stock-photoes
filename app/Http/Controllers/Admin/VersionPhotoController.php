<?php

namespace App\Http\Controllers\Admin;

// Add your error reporting lines here
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Category;
use App\VersionPhoto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Photo;
use Illuminate\Support\Facades\Redirect;
use App\Services\PhotoService;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Imagick;
use App\Subcategory;

class VersionPhotoController extends Controller
{
    protected $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $photo_id, $counter, $color_create_version, $category_name)
    {
        $category_name_1 = html_entity_decode(urldecode($request->query('category')));
        // dd($category_name_1);
        $subcategory_1 = html_entity_decode(urldecode($request->query('subcategory')));
        // dd($category_name_1, $subcategory_1);
        // dd($photo_id, $counter, $color);

        // $photo_id = $request->photo_id;
        // $counter = $request->counter;
        // $color = $request->color;
        // $category_name = Photo::find($photo_id)->category->name;
        $photo_title = Photo::find($photo_id)->title;

        if($color_create_version == 'C'){
            $color = 'Farbe';
        } elseif($color_create_version == 'B') {
            $color = 'color';
        } elseif($color_create_version == 'S') {
            $color = 'Sepia';
        }

        return view('admin.version_photos.create', compact('photo_id', 'counter', 'color_create_version', 'category_name_1',
        'subcategory_1',
        'color',
        'photo_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ini_set('max_execution_time', 3000);
        $category_name_1 = $request->category_name_1;
        $subcategory_id_1 = $request->subcategory_1;

        $category_id = Category::where('name', $category_name_1)->first()->id;


        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:207048',
        ]);

        //

        $version_photo                       =    new VersionPhoto();
        $version_photo->status               =    $request->status;
        // $version_photo->description          =    $request->description;
        $version_photo->color_create_version =    $request->color_create_version;
        $version_photo->photo_id             =    $request->photo_id;
        // $version_photo->type                 =    $request->type;
        // $version_photo->EK_year              =    $request->EK_year;
        // $version_photo->EK_price             =    $request->EK_price;
        // $version_photo->image_year           =    $request->image_year;
        // $version_photo->photographer         =    $request->photographer;
        // $version_photo->OF_height            =    $request->OF_height;
        // $version_photo->OF_width             =    $request->OF_width;
        // $version_photo->weather              =    $request->weather;
        // $version_photo->season               =    $request->season;
        // $version_photo->color_select         =    $request->color_select;
        $version_photo->price                =    $request->price;
        // $version_photo->title                =     $request->title;
        $version_photo->category_id          =    $category_id;
        $version_photo->sub_category_id       =    $subcategory_id_1;


        $last_version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', $request->color_create_version)
        ->orderBy('counter', 'desc')->first();
        // dd($last_version_photo);

        if(!$last_version_photo){
            $counter = 1;
            $version_photo->counter = $counter;

        } else {
            $version_photo->counter = $last_version_photo->counter + 1;
        }

        if($version_photo->counter < 10){
            $version_photo->counter = '0'.$version_photo->counter;
        }


        $versionCounter = $version_photo->counter;


        if($request->hasfile('image'))
         {
             // Get the original DPI
            $image = $request->file('image');
            $imagick = new \Imagick();
            $imagick->readImage($image->getRealPath());
            $resolution = $imagick->getImageResolution();
            $originalDpi = $resolution['x'];


            $manager                        = new ImageManager(['driver' => 'imagick']);
            $original_filename              = $request->file('image')->getClientOriginalName();
            $image                          = $request->file('image');
            $imgFileCollection1              = Image::make($image->getRealPath());
            $height_imgFileCollection       = $imgFileCollection1->height();
            $width_imgFileCollection        = $imgFileCollection1->width();

            if($height_imgFileCollection    > $width_imgFileCollection) {
                $width_imgFileCollection    = (2048/$width_imgFileCollection) * $height_imgFileCollection;

                $width_imgFileCollection    = round($width_imgFileCollection);
                $height_imgFileCollection   = 2048;


            } elseif ($width_imgFileCollection > $height_imgFileCollection) {
                $height_imgFileCollection   = (2048/$width_imgFileCollection) * $height_imgFileCollection;

                $height_imgFileCollection   = round($height_imgFileCollection);
                $width_imgFileCollection    = 2048;

            } else {
                $height_imgFileCollection   = 2048;
                $width_imgFileCollection    = 2048;
            }


            $imgFileCollection1->resize($width_imgFileCollection, $height_imgFileCollection, function($constraint)
            {
                $constraint->aspectRatio();

            });

            $resized_width_imgFileCollection  = $imgFileCollection1->width();
            $resized_height_imgFileCollection = $imgFileCollection1->height();

            $imageName              =  'nzphotos-' . $request->color_create_version . $request->photo_id. $versionCounter.'-'.$resized_width_imgFileCollection.'x'.$resized_height_imgFileCollection.'.jpg';
            $imagePath                = public_path() . '/images/version_photos/';
            $imgFileCollection1->save($imagePath . $imageName, 100);

            // Set the original DPI to the saved image
            $imagickImage = new \Imagick($imagePath . $imageName);
            $imagickImage->setImageResolution($originalDpi, $originalDpi);
            $imagickImage->writeImage($imagePath . $imageName);
            $imagickImage->destroy();
            //ends here


            //thumbnail

            $widthThumbnail = 150;
            $heightThumbnail = 93;
            $imgFileCollection2              = Image::make($image->getRealPath());
            $imagePaththumbnail              = public_path() . '/images/version_photos/thumbnail/';
            $imgFileCollection2->resize($widthThumbnail, $heightThumbnail, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $thumbnail                      =  'nzphotos-' . $request->color_create_version . $request->photo_id. $versionCounter.'-'
            .$imgFileCollection2->width()
            .'x'
            .$imgFileCollection2->height()
            .'.jpg';
            $imgFileCollection2->save($imagePaththumbnail . $thumbnail, 100);

            $imagickImage = new \Imagick($imagePaththumbnail . $thumbnail);
            $imagickImage->setImageResolution($originalDpi, $originalDpi);
            $imagickImage->writeImage($imagePaththumbnail . $thumbnail);
            $imagickImage->destroy();

            //ends here


            //original image

                $imgFileCollection3             = Image::make($image->getRealPath());
                $pathOfImageOriginal            = public_path() . '/images/version_photos/originalImage/';
                $originalImage              =  'nzphotos-' . $request->color_create_version . $request->photo_id. $versionCounter. '-original.jpg';
                $imgFileCollection3->save($pathOfImageOriginal . $originalImage, 100);

            //ends here

             $image                         = $request->file('image');
             $pathOfWatermarkImage          = public_path() . '/images/version_photos/singleImage/';

             $SingleImage                   = Image::make($image->getRealPath());
             $width_SingleImage             = $SingleImage->width();
             $height_SingleImage            = $SingleImage->height();


             if($height_SingleImage > $width_SingleImage) {
                 $width_SingleImage = (2048/$width_SingleImage) * $height_SingleImage;
                 $width_SingleImage = round($width_SingleImage);
                 $height_SingleImage = 2048;


             } elseif ($width_SingleImage > $height_SingleImage) {
                 $height_SingleImage = (2048/$width_SingleImage) * $height_SingleImage;
                 $height_SingleImage = round($height_SingleImage);
                 $width_SingleImage = 2048;

             } else {
                 $height_SingleImage = 2048;
                 $width_SingleImage = 2048;

             }



             $SingleImage->resize($width_SingleImage, $height_SingleImage, function($constraint)
             {
                 $constraint->aspectRatio();

             });

            $resizedWidth_SingleImage = $SingleImage->width();
            $resizedHeight_SingleImage = $SingleImage->height();

              //
              $imageNameCIDCOUNTER           = 'nzphotos-'.$version_photo->color_create_version.$request->photo_id.$version_photo->counter.'-'.$resizedWidth_SingleImage.'x'.$resizedHeight_SingleImage.'.jpg';
            //   $version_photo->image_name     = $imageNameCIDCOUNTER;
              $ImageNameWatermark            = $imageNameCIDCOUNTER;
              //

             $watermarkPath          = public_path('frontend/img/logo.png');
             $imgHeight              = $SingleImage->height();
             $imgWidth               = $SingleImage->width();

             if($imgWidth > $imgHeight) {
             $watermark              = Image::make($watermarkPath)->resize(500, 120)->opacity(30);
             $wmarkWidth             = $watermark->width();
             $wmarkHeight            = $watermark->height();


             $x                      = 20;
             $xx                     = 40;
             $y                      = 20;

             while ($x < $imgWidth) {
                 $y = 20;
                 $xx = $x;
                 $line = 1;
                 while($y < $imgHeight) {
                     if($line%2 == 0) {
                         $xx = $x+290;
                     }
                     $SingleImage->insert($watermark, 'top-left', $xx, $y);
                     $y += $wmarkHeight+180;
                     $xx = $x;

                     $line += 1;
                 }

                   $x += $wmarkWidth+150;

             }
            } else {
                 $watermark              = Image::make($watermarkPath)->resize(750, 180)->opacity(30);
                 $wmarkWidth             = $watermark->width();
                 $wmarkHeight            = $watermark->height();


             $x                      = 20;
             $xx                     = 40;
             $y                      = 20;

             while ($x < $imgWidth) {
                 $y = 20;
                 $xx = $x;
                 $line = 1;
                 while($y < $imgHeight) {
                     if($line%2 == 0) {
                         $xx = $x+290;
                     }
                     $SingleImage->insert($watermark, 'top-left', $xx, $y);
                     $y += $wmarkHeight+220;
                     $xx = $x;

                     $line += 1;
                 }

                   $x += $wmarkWidth+150;
             }
        }

        $SingleImage->save($pathOfWatermarkImage . $ImageNameWatermark, 100); //for single image

        $imagickImage = new \Imagick($pathOfWatermarkImage . $ImageNameWatermark);
        $imagickImage->setImageResolution($originalDpi, $originalDpi);
        $imagickImage->writeImage($pathOfWatermarkImage . $ImageNameWatermark);
        $imagickImage->destroy();


        //ends here


        }

        $photo_id                               = $request->photo_id;

        $last_version_photo = VersionPhoto::where('photo_id', $photo_id)
                                    ->where('color_create_version', $request->color_create_version)
                                    ->orderBy('counter', 'desc')
                                    ->first();
        if($last_version_photo){
            $any_version_photo = VersionPhoto::where('photo_id', $photo_id)
                                    ->where('color_create_version', $request->color_create_version)
                                    ->where('status', 'on')
                                    ->first();
        if($any_version_photo){
            $data['status'] = 'off';
        } else {
            $data['status'] = 'on';
        }

        } else {
            $data['status'] = 'on';
        }

        $version_photo->image                =    $imageName;
        $version_photo->small_thumbnail      =    $thumbnail;
        $version_photo->original_image       =    $originalImage;
        $version_photo->original_filename    =    $original_filename;
        $version_photo->status               =    $data['status'];
        $version_photo->singleImage          =    $imageNameCIDCOUNTER;


        $version_photo->save();

        if($version_photo->color_create_version == 'C'){
            $color = 'Farbe';
        }elseif($version_photo->color_create_version == 'B'){
            $color = 'color';
        }else{
            $color = 'Sepia';
        }
        // dd($color);

        return Redirect::to('admin/edit/photos/'. $category_name_1 . '/' . $photo_id . '#'. $color);
        // return redirect()->route('admin.edit.photos', ['category_name' => $category_name_1, 'photo_id' => $photo_id, 'color' => $color]);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VersionPhoto  $versionPhoto
     * @return \Illuminate\Http\Response
     */
    public function show(VersionPhoto $versionPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VersionPhoto  $versionPhoto
     * @return \Illuminate\Http\Response
     */
    public function edit(VersionPhoto $versionPhoto, $version_id)
    {
        // dd($version_id);
        $version_photo = VersionPhoto::find($version_id);
        $photo_id = $version_photo->photo_id;
        $category_name = Photo::find($photo_id)->category->name;
        $photo_title = Photo::find($photo_id)->title;
        $counter = $version_photo->counter;
        $color = $version_photo->color_create_version;

        return view('admin.version_photos.edit', compact('version_photo', 'photo_id', 'category_name', 'photo_title', 'counter', 'color',
        'version_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VersionPhoto  $versionPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VersionPhoto $versionPhoto)
    {
        // dd($request->all());

        $category_name = $request->category_name;

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:207048',
        ]);

        if($request->hasfile('image'))
         {
            // Get the original DPI of the image
            $image = $request->file('image');
            $imagick = new \Imagick();
            $imagick->readImage($image->getRealPath());
            $resolution = $imagick->getImageResolution();
            $originalDpi = $resolution['x'];

            $time = time();
            $original_filename = $request->file('image')->getClientOriginalName();
            $imgFileCollection1              = Image::make($image->getRealPath());
            $height_imgFileCollection       = $imgFileCollection1->height();
            $width_imgFileCollection        = $imgFileCollection1->width();
            if($height_imgFileCollection    > $width_imgFileCollection) {
                $width_imgFileCollection    = (2048/$height_imgFileCollection) * $width_imgFileCollection;

                $width_imgFileCollection    = round($width_imgFileCollection);
                $height_imgFileCollection   = 2048;


            } elseif ($width_imgFileCollection > $height_imgFileCollection) {
                $height_imgFileCollection   = (2048/$width_imgFileCollection) * $height_imgFileCollection;

                $height_imgFileCollection   = round($height_imgFileCollection);
                $width_imgFileCollection    = 2048;

            } else {
                $height_imgFileCollection   = 2048;
                $width_imgFileCollection    = 2048;
            }
           //$imageName = $this->photoService->imagesFolder($request, $imagePath, $width_imgFileCollection, $height_imgFileCollection, $time);


            $imgFileCollection1->resize($width_imgFileCollection, $height_imgFileCollection, function($constraint)
            {
                $constraint->aspectRatio();

            });

            $resized_width_imgFileCollection  = $imgFileCollection1->width();
            $resized_height_imgFileCollection = $imgFileCollection1->height();

            $imageName              =  'nzphotos-' . $request->color_create_version . $request->photo_id.'-'.$resized_width_imgFileCollection.'x'.$resized_height_imgFileCollection.'.jpg';
            $imagePath                = public_path() . '/images/version_photos/';
            $imgFileCollection1->save($imagePath . $imageName, 100);

            // Set the original DPI to the saved image
            $imagickImage = new \Imagick($imagePath . $imageName);
            $imagickImage->setImageResolution($originalDpi, $originalDpi);
            $imagickImage->writeImage($imagePath . $imageName);
            $imagickImage->destroy();

            //ends here


            //starts here thumbnail
            $widthThumbnail = 150;
            $heightThumbnail = 93;
            //$thumbnail = $this->photoService->imagesFolder($request, $imagePaththumbnail, $widthThumbnail, $heightThumbnail, $time);
            $imgFileCollection2              = Image::make($image->getRealPath());
            $imagePaththumbnail              = public_path() . '/images/version_photos/thumbnail/';
            $thumbnail                      =  'nzphotos-' . $request->color_create_version . $request->photo_id.'-'.$widthThumbnail.'x'.$heightThumbnail.'.jpg';
            $imgFileCollection2->resize($widthThumbnail, $heightThumbnail, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $imgFileCollection2->save($imagePaththumbnail . $thumbnail, 100);

            $imagickImage = new \Imagick($imagePaththumbnail . $thumbnail);
            $imagickImage->setImageResolution($originalDpi, $originalDpi);
            $imagickImage->writeImage($imagePaththumbnail . $thumbnail);
            $imagickImage->destroy();

            //ends here

            //starts original image
            //$originalImage = $this->photoService->imagesFolder($request, $originalPath,  $witdthOriginal, $heightOriginal, $time);

            $imgFileCollection3             = Image::make($image->getRealPath());
                $pathOfImageOriginal            = public_path() . '/images/version_photos/originalImage/';
                $originalImage              =  'nzphotos-' . $request->color_create_version . $request->photo_id. 'original.jpg';
                $imgFileCollection3->save($pathOfImageOriginal . $originalImage, 100);

            //ends here


            //
             $image                         = $request->file('image');
             $pathOfWatermarkImage          = public_path() . '/images/version_photos/singleImage/';
             $SingleImage                   = Image::make($image->getRealPath());
             $width_SingleImage             = $SingleImage->width();
             $height_SingleImage            = $SingleImage->height();


             if($height_SingleImage > $width_SingleImage) {
                 $width_SingleImage = (2048/$height_SingleImage) * $width_SingleImage;
                 $width_SingleImage = round($width_SingleImage);
                 $height_SingleImage = 2048;


             } elseif ($width_SingleImage > $height_SingleImage) {
                 $height_SingleImage = (2048/$width_SingleImage) * $height_SingleImage;
                 $height_SingleImage = round($height_SingleImage);
                 $width_SingleImage = 2048;

             } else {
                 $height_SingleImage = 2048;
                 $width_SingleImage = 2048;

             }

             $SingleImage->resize($width_SingleImage, $height_SingleImage, function($constraint)
             {
                 $constraint->aspectRatio();

             });

             //
             $resizedWidth_SingleImage = $SingleImage->width();
             $resizedHeight_SingleImage = $SingleImage->height();

               //
               $imageNameCIDCOUNTER           = 'nzphotos-'.$request->photo_id.'-'.$resizedWidth_SingleImage.'x'.$resizedHeight_SingleImage.'.jpg';
               $ImageNameWatermark            = $imageNameCIDCOUNTER;
               //
             //

             $watermarkPath          = public_path('frontend/img/logo.png');
             $imgHeight              = $SingleImage->height();
             $imgWidth               = $SingleImage->width();

             if($imgWidth > $imgHeight) {
             $watermark              = Image::make($watermarkPath)->resize(500, 120)->opacity(30);
             $wmarkWidth             = $watermark->width();
             $wmarkHeight            = $watermark->height();


             $x                      = 20;
             $xx                     = 40;
             $y                      = 20;

             while ($x < $imgWidth) {
                 $y = 20;
                 $xx = $x;
                 $line = 1;
                 while($y < $imgHeight) {
                     if($line%2 == 0) {
                         $xx = $x+290;
                     }
                     $SingleImage->insert($watermark, 'top-left', $xx, $y);
                     $y += $wmarkHeight+180;
                     $xx = $x;

                     $line += 1;
                 }

                   $x += $wmarkWidth+150;

             }
            } else {
                 $watermark              = Image::make($watermarkPath)->resize(750, 180)->opacity(30);
                 $wmarkWidth             = $watermark->width();
                 $wmarkHeight            = $watermark->height();


             $x                      = 20;
             $xx                     = 40;
             $y                      = 20;

             while ($x < $imgWidth) {
                 $y = 20;
                 $xx = $x;
                 $line = 1;
                 while($y < $imgHeight) {
                     if($line%2 == 0) {
                         $xx = $x+290;
                     }
                     $SingleImage->insert($watermark, 'top-left', $xx, $y);
                     $y += $wmarkHeight+220;
                     $xx = $x;

                     $line += 1;
                 }

                   $x += $wmarkWidth+150;

             }
             }

            $SingleImage->save($pathOfWatermarkImage . $ImageNameWatermark, 100); //for single image

            $imagickImage = new \Imagick($pathOfWatermarkImage . $ImageNameWatermark);
            $imagickImage->setImageResolution($originalDpi, $originalDpi);
            $imagickImage->writeImage($pathOfWatermarkImage . $ImageNameWatermark);
            $imagickImage->destroy();

            //ends here

         }



        $data['image']                          = $imageName;
        $data['small_thumbnail']                = $thumbnail;
        $data['original_image']                 = $originalImage;
        $data['original_filename']              = $original_filename;
        $date['status']                         = 'on';
        $data['singleImage']                    = $ImageNameWatermark;

        $version_photo = VersionPhoto::find($request->version_id);

        $version_photo->update($data);


        $photo_id = $version_photo->photo_id;

        if($version_photo->color_create_version == 'C'){
            $color = 'Farbe';
        }elseif($version_photo->color_create_version == 'B'){
            $color = 'color';
        }else{
            $color = 'Sepia';
        }

        // return Redirect::to('admin/edit/photos/'. $category_name . '/' . $photo_id . '#'. $color);
        return redirect()->back()->with('success', 'Version Photo Updated Successfully!');


    }

    public function updateCategoriesVersion(Request $request)
    {

        if($request->category_name_color_cat1 != null){
        $category_id = Category::where('name', $request->category_name_color_cat1)->first()->id;
        }else{
            $category_id = null;
        }


        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'C')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id' => $category_id,
            'sub_category_id' => $request->subcategory_id_color_cat1,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id' => $category_id,
        //     'sub_category_id' => $request->subcategory_id_color_cat1,
        // ]);

        return response()->json(['status'=> true ]);
    }

    public function updateCategoriesVersion2(Request $request)
    {

        if($request->category_name_color_cat2 != null){
        $category_id = Category::where('name', $request->category_name_color_cat2)->first()->id;
        }else{
            $category_id = null;
        }


        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'C')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id_2' => $category_id,
            'sub_category_id_2' => $request->subcategory_id_color_cat2,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id_2' => $category_id,
        //     'sub_category_id_2' => $request->subcategory_id_color_cat2,
        // ]);

        return response()->json(['status'=> true ]);
    }

    public function updateCategoriesVersion3(Request $request)
    {

        if($request->category_name_color_cat3 != null){
        $category_id = Category::where('name', $request->category_name_color_cat3)->first()->id;
        }else{
            $category_id = null;
        }

        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'C')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id_3' => $category_id,
            'sub_category_id_3' => $request->subcategory_id_color_cat3,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id_3' => $category_id,
        //     'sub_category_id_3' => $request->subcategory_id_color_cat3,
        // ]);

        return response()->json(['status'=> true ]);
    }

     public function updateCategoriesVersion4(Request $request)
    {

        if($request->category_name_black_cat1 != null){
        $category_id = Category::where('name', $request->category_name_black_cat1)->first()->id;
        }else{
            $category_id = null;
        }

        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'B')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id' => $category_id,
            'sub_category_id' => $request->subcategory_id_black_cat1,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id' => $category_id,
        //     'sub_category_id' => $request->subcategory_id_black_cat1,
        // ]);

        return response()->json(['status'=> true ]);
    }

    public function updateCategoriesVersion5(Request $request)
    {

        if($request->category_name_black_cat2 != null){
        $category_id = Category::where('name', $request->category_name_black_cat2)->first()->id;
        }else{
            $category_id = null;
        }

        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'B')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id_2' => $category_id,
            'sub_category_id_2' => $request->subcategory_id_black_cat2,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id_2' => $category_id,
        //     'sub_category_id_2' => $request->subcategory_id_black_cat2,
        // ]);

        return response()->json(['status'=> true ]);
    }

    public function updateCategoriesVersion6(Request $request)
    {

        if($request->category_name_black_cat3 != null){
        $category_id = Category::where('name', $request->category_name_black_cat3)->first()->id;
        }else{
            $category_id = null;
        }

        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'B')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id_3' => $category_id,
            'sub_category_id_3' => $request->subcategory_id_black_cat3,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id_3' => $category_id,
        //     'sub_category_id_3' => $request->subcategory_id_black_cat3,
        // ]);

        return response()->json(['status'=> true ]);
    }

    public function updateCategoriesVersion7(Request $request)
    {

        if($request->category_name_sepia_cat1 != null){
        $category_id = Category::where('name', $request->category_name_sepia_cat1)->first()->id;
        }else{
            $category_id = null;
        }

        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'S')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id' => $category_id,
            'sub_category_id' => $request->subcategory_id_sepia_cat1,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id' => $category_id,
        //     'sub_category_id' => $request->subcategory_id_sepia_cat1,
        // ]);

        return response()->json(['status'=> true ]);
    }

    public function updateCategoriesVersion8(Request $request)
    {

        if($request->category_name_sepia_cat2 != null){
        $category_id = Category::where('name', $request->category_name_sepia_cat2)->first()->id;
        }else{
            $category_id = null;
        }

        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'S')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id_2' => $category_id,
            'sub_category_id_2' => $request->subcategory_id_sepia_cat2,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id_2' => $category_id,
        //     'sub_category_id_2' => $request->subcategory_id_sepia_cat2,
        // ]);

        return response()->json(['status'=> true ]);
    }

    public function updateCategoriesVersion9(Request $request)
    {

        if($request->category_name_sepia_cat3 != null){
        $category_id = Category::where('name', $request->category_name_sepia_cat3)->first()->id;
        }else{
            $category_id = null;
        }

        $version_photo = VersionPhoto::where('photo_id', $request->photo_id)
        ->where('color_create_version', 'S')
        // ->where('status', 'on')
        ;
        $version_photo->update([
            'category_id_3' => $category_id,
            'sub_category_id_3' => $request->subcategory_id_sepia_cat3,
        ]);

        // $photo = Photo::find($request->photo_id);

        // $photo->update([
        //     'category_id_3' => $category_id,
        //     'sub_category_id_3' => $request->subcategory_id_sepia_cat3,
        // ]);

        return response()->json(['status'=> true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VersionPhoto  $versionPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);

        $version_photo = VersionPhoto::find($id);

        $version_photo->delete();

        //return as a json response
        return response()->json(['status'=> true ]);



    }

    public function updateStatus(Request $request)
    {
        // dd($request->input('id'), $request->input('status'));
        $version_photo = VersionPhoto::find($request->input('id'));
        $version_photo->status = $request->input('status');
        // dd($version_photo->status);
        $counter = $version_photo->counter;
        $version_photo->save();
        //send different response based on status
        if($version_photo->status == 'on'){
            $status = 'Active';
            $message = 'Version Photo ist jetzt aktiv';
        }else{
            $status = 'Inactive';
            $message = 'Version Photo ist jetzt inaktiv';
        }
        return response()->json(['status'=>$status, 'message'=>$message, 'counter'=>$counter]);
    }

    public function updateStatus1(Request $request, $id)
        {

            $versionPhoto = VersionPhoto::find($id);
            $versionPhoto->status = $request->input('status');
            $versionPhoto->save();

            if ($request->input('status') == 'on') {
                // get the ID of the last "on" item
                $lastOnItem = VersionPhoto::where('status', 'on')
                ->where('color_create_version', $request->color_create_version)
                ->first();

                // assign the ID of the last "on" item to the newly created "on" item
                $versionPhoto->category_id = $lastOnItem->category_id;
                $versionPhoto->sub_category_id = $lastOnItem->sub_category_id;
                $versionPhoto->category_id_2 = $lastOnItem->category_id_2;
                $versionPhoto->sub_category_id_2 = $lastOnItem->sub_category_id_2;
                $versionPhoto->category_id_3 = $lastOnItem->category_id_3;
                $versionPhoto->sub_category_id_3 = $lastOnItem->sub_category_id_3;
                $versionPhoto->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Item updated successfully.'
            ]);
        }

}
