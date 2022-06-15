<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SubCategory;
use Illuminate\Support\Facades\DB;
use Image;
use response;
use Imagick;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::with('Category')->get();
        // dd($subcategories);
        return view('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('categories')->get()->pluck('name', 'id');
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

         $image = new SubCategory;
         $image->name = $request->name;
         $image->image_title = $request->image_title;
         $image->category_id = $request->category_id;
         $image->image_price = $request->image_price;


        // pick logo from local folder

        $uploadedimagepicklogo = $request->file('image');
        $inputResized['image'] = time().$uploadedimagepicklogo->getClientOriginalName();
        $watermark = $request->file('watermark');
        $watermark1['watermark'] = time().$watermark->getClientOriginalName();
        $imgFile = Image::make($uploadedimagepicklogo->getRealPath())->resize(540, 405);       //image resize from here;
        $watermark = Image::make($watermark->getRealPath())->opacity(50);   // watermark resize from here
        $path = storage_path('app/public/subcategories').'/'.$inputResized['image'];
        $imgFile->insert($watermark, 'center')->save($path);
        $image->image =  $inputResized['image'];

        // // end pick logo from local




        // // single image start

        $uploadedimagesingle = $request->file('image');
        $inputsingle['image'] = time().$uploadedimagesingle->getClientOriginalName();
        $watermark = $request->file('watermark');
        $watermark1['watermark'] = time().$watermark->getClientOriginalName();
        $imgFilesingle = Image::make($uploadedimagesingle->getRealPath())->resize(1024, 768);       //image resize from here;
        $watermarksingle = Image::make($watermark->getRealPath())->opacity(30);   // watermark resize from here
        $pathsingle = storage_path('app/public/subcategories').'/'.$inputsingle['image'];
        $imgFilesingle->insert($watermarksingle, 'center')->save($pathsingle);
        $image->image_singlePage =  $inputsingle['image'];

        // // end single image



        // // original image

        $uploadedoriginalImage = $request->file('image');

        $originalinput['image'] = time().$uploadedoriginalImage->getClientOriginalName();
        $imgFileoriginal = Image::make($uploadedoriginalImage->getRealPath());       // original image
        $pathoriginal = storage_path('app/public/subcategories').'/'.$originalinput['image'];
        $imgFileoriginal->save($pathoriginal);
        $height = Image::make($uploadedoriginalImage)->height();      // height of the original image
        $width = Image::make($uploadedoriginalImage)->width();
        $image->originalImage = $originalinput['image'];
        $image->height =  $height;
        $image->width =  $width;


        // end original image


        // resoltuion of images
        $uploadedoriginalImageresol = $request->file('image');
        $originalinputresolution['image'] = time().$uploadedoriginalImageresol->getClientOriginalName();
        $imgFileoriginalreso = Image::make($uploadedoriginalImageresol->getRealPath());       // original image
        $pathoriginalresolution = storage_path('app/public/subcategories').'/'.$originalinputresolution['image'];
        $imgFileoriginalreso->save($pathoriginalresolution);
        $imagick = new Imagick($pathoriginalresolution);
        $imagick->setImageResolution(300,300) ; // it change only image density.

        $getimagreso = $imagick->getImageResolution();
        // dd($getimagreso['x']);
        // dd($getimagreso['y']);

        $saveImagePath = storage_path('app/public/subcategories/300dpiImages') . '/' . $originalinputresolution['image'];
        $imagick->writeImages($saveImagePath, true);

        $image->dpiImage = $originalinputresolution['image'];
        // end resol of images



        $image->save();
        return response()->json('Image uploaded successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $SubCategory = SubCategory::findOrfail($id);
        $categories = DB::table('categories')->get()->pluck('name', 'id');
        return view('admin.subcategories.edit', compact('SubCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $image = SubCategory::find($request->id);
        // dd($image);
        $image->name = $request->name;
        $image->image_title = $request->image_title;
        $image->category_id = $request->category_id;
        $image->image_price = $request->image_price;

        //

        // pick logo from local folder

        $uploadedimagepicklogo = $request->file('image');
        $inputResized['image'] = time().$uploadedimagepicklogo->getClientOriginalName();

        //pick logo from the user

        $watermark = $request->file('watermark');
        $watermark1['watermark'] = time().$watermark->getClientOriginalName();

        // end pick logo from the user

        // watermark start in local folder

        $imgFile = Image::make($uploadedimagepicklogo->getRealPath())->resize(540, 405);       //image resize from here;
        $watermark = Image::make($watermark->getRealPath())->opacity(50);   // watermark resize from here

        $path = storage_path('app/public/subcategories').'/'.$inputResized['image'];
        $imgFile->insert($watermark, 'center')->save($path);
        // end watermark in local folder

        $image->image =  $inputResized['image'];

        // end pick logo from local

        //


        // single image start

        $uploadedimagesingle = $request->file('image');
        $inputsingle['image'] = time().$uploadedimagesingle->getClientOriginalName();

         //pick logo from the user

         $watermark = $request->file('watermark');
         $watermark1['watermark'] = time().$watermark->getClientOriginalName();

         // end pick logo from the user

        //watermark start in local folder

        $imgFilesingle = Image::make($uploadedimagesingle->getRealPath())->resize(1024, 768);       //image resize from here;
        $watermarksingle = Image::make($watermark->getRealPath())->opacity(30);   // watermark resize from here

        $pathsingle = storage_path('app/public/subcategories').'/'.$inputsingle['image'];
        $imgFilesingle->insert($watermarksingle, 'center')->save($pathsingle);

        // end watermark in local folder

        $image->image_singlePage =  $inputsingle['image'];


        // end single image

        // original image

        // $originalimage = Image::make($uploadedimagesingle->getRealPath());


          // // original image

        $uploadedoriginalImage = $request->file('image');

        $originalinput['image'] = time().$uploadedoriginalImage->getClientOriginalName();
        $imgFileoriginal = Image::make($uploadedoriginalImage->getRealPath());       // original image
        $pathoriginal = storage_path('app/public/subcategories').'/'.$originalinput['image'];
        $imgFileoriginal->save($pathoriginal);
        $height = Image::make($uploadedoriginalImage)->height();      // height of the original image
        $width = Image::make($uploadedoriginalImage)->width();
        $image->originalImage = $originalinput['image'];
        $image->height =  $height;
        $image->width =  $width;


        // end original image


        // resoltuion of images
        $uploadedoriginalImageresol = $request->file('image');
        $originalinputresolution['image'] = time().$uploadedoriginalImageresol->getClientOriginalName();
        $imgFileoriginalreso = Image::make($uploadedoriginalImageresol->getRealPath());       // original image
        $pathoriginalresolution = storage_path('app/public/subcategories').'/'.$originalinputresolution['image'];
        $imgFileoriginalreso->save($pathoriginalresolution);
        $imagick = new Imagick($pathoriginalresolution);
        $imagick->setImageResolution(300,300) ; // it change only image density.


        $saveImagePath = storage_path('app/public/subcategories/300dpiImages') . '/' . $originalinputresolution['image'];
        $imagick->writeImages($saveImagePath, true);

        $image->dpiImage = $originalinputresolution['image'];
        // end resol of images





          $image->update();

         return redirect()->route('admin.subcategories')->with('message', 'image uploaded successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = SubCategory::find($id);
        $Category->delete();
        return redirect()->back()->with('message', 'Sub Category deleted successfully' );
    }

}

