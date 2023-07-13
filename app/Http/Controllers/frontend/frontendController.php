<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Photo;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\VersionPhoto;



class frontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $categoryId = '';
        $subCategoryId = '';
        $categoryName   = '';

        // $subcategories = SubCategory::all();
        // $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();

        $date = "2020-12-31 23:59:59";
        $carbon = Carbon::parse($date);
        // dd($carbon);


        return view('web.home', compact('categories', 'categoryId', 'subCategoryId', 'categoryName'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function collections(Request $request, $categoryId, $categoryName, $subcategoryId = null)
    {
        // dd($categoryId, $categoryName, $subcategoryId);
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();

        // $latestPhotos  = Photo::where('category_id', $categoryId)->orderBy('created_at', 'desc')->paginate(12);

        $latest_Version_Photos  = VersionPhoto::with('photo')->where('status', 'on')
        ->where(function($query) use ($categoryId) {
            $query->where('category_id', $categoryId)
                  ->orWhere('category_id_2', $categoryId)
                  ->orWhere('category_id_3', $categoryId);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(12);

        // dd($latest_Version_Photos);


        return view('web.products.collection', compact('categories' , 'categoryId' ,'subcategories', 'subcategoryId' ,'categoryName',
        'latest_Version_Photos'));

    }
    //function for photo_collections
    public function photo_collections(Request $request, $categoryId, $categoryName, $subcategoryId, $subcategoryName)
    {

        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();

        // $latestPhotos = Photo::where('category_id', $categoryId)->where('sub_category_id', $subcategoryId)->orderBy('created_at', 'asc')->paginate(12);

        $latestVersion_Photos = VersionPhoto::with('photo')->where('status', 'on')
        ->where(function($query) use ($categoryId, $subcategoryId) {
            $query->where('category_id', $categoryId)
                  ->where('sub_category_id', $subcategoryId)
                  ->orWhere('category_id_2', $categoryId)
                  ->where('sub_category_id_2', $subcategoryId)
                  ->orWhere('category_id_3', $categoryId)
                  ->where('sub_category_id_3', $subcategoryId);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(12);


        // dd($latestVersion_Photos);



        if($latestVersion_Photos->isEmpty()){
            $message = "Keine Fotos gefunden";
        }else{
            $message = "";
        }

        return view('web.products.photo_collection', compact('categories', 'subcategoryId' ,'message' , 'categoryId' ,'subcategories',
        'categoryName', 'subcategoryName', 'latestVersion_Photos'));

    }

    //make function for NewestCollection
    public function NewestCollection(Request $request)
    {

        $categoryId = '';
        $subCategoryId = '';
        $categoryName   = '';
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategories = SubCategory::all();

        return view('web.products.newest_collection' , compact('categoryId', 'subCategoryId', 'categoryName', 'categories', 'subcategories'));
    }

    public function singleImage(Request $request, $category_id, $image_id, $subcategoryId = null, $categoryId = null)
    {
        $image = VersionPhoto::where('status', 'on')->findOrFail($image_id);
    // Check if $categoryId and $subcategoryId are not provided and set it with image's category and subcategory ID
    $categoryId = $categoryId ?? $image->category_id;
    $subcategoryId = $subcategoryId ?? $image->sub_category_id;

    //storage path
    $public_path = public_path() . '/images/version_photos/originalImage/' . $image->original_image;

    //getImageResolution from Imagick
    $imageDPI = new \Imagick($public_path);
    //get image width
    $imageWidth = $imageDPI->getImageWidth();
    //get image height
    $imageHeight = $imageDPI->getImageHeight();
    //get image dpi
    $dpi = $imageDPI->getImageResolution();
    $horizontalDPI = $dpi['x'];
    $verticalDPI = $dpi['y'];

    $category       = Category::with('subcategory')->where('id', $image->category_id)->first();
    $subcategory    = SubCategory::where('id', $image->sub_category_id)->first();
    $categoryName   = '';

    $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
    $subcategories = SubCategory::all();

    $nextID = VersionPhoto::where('status', 'on')
        ->where(function ($query) use ($categoryId, $subcategoryId) {
            $query->where(function ($query) use ($categoryId, $subcategoryId) {
                $query->where('category_id', $categoryId)
                    ->where('sub_category_id', $subcategoryId);
            })->orWhere(function ($query) use ($categoryId, $subcategoryId) {
                $query->where('category_id_2', $categoryId)
                    ->where('sub_category_id_2', $subcategoryId);
            })->orWhere(function ($query) use ($categoryId, $subcategoryId) {
                $query->where('category_id_3', $categoryId)
                    ->where('sub_category_id_3', $subcategoryId);
            });
        })
        ->orderBy('created_at', 'desc')
        ->where('id', '<', $image_id)
        ->max('id');
    // dd($previousID);

    $previousID = VersionPhoto::where('status', 'on')
        ->where(function ($query) use ($categoryId, $subcategoryId) {
            $query->where(function ($query) use ($categoryId, $subcategoryId) {
                $query->where('category_id', $categoryId)
                    ->where('sub_category_id', $subcategoryId);
            })->orWhere(function ($query) use ($categoryId, $subcategoryId) {
                $query->where('category_id_2', $categoryId)
                    ->where('sub_category_id_2', $subcategoryId);
            })->orWhere(function ($query) use ($categoryId, $subcategoryId) {
                $query->where('category_id_3', $categoryId)
                    ->where('sub_category_id_3', $subcategoryId);
            });
        })
        ->orderBy('created_at', 'desc')
        ->where('id', '>', $image_id)
        ->min('id');


        return view('web.products.singleImage', compact('category', 'subcategory', 'categories' ,'image'
        ,'imageWidth' ,'imageHeight' ,'nextID' ,'previousID' ,'subcategories', 'horizontalDPI', 'verticalDPI', 'subcategoryId', 'category_id', 'categoryName',
        'categoryId'
        ));
    }

    public function singleImage2(Request $request, $category_id, $image_id, $categoryId = null)
    {
        $image         = VersionPhoto::where('status', 'on')->findorfail($image_id);
        $category_id = $image->category_id;
        $category_id_2 = $image->category_id_2;
        $category_id_3 = $image->category_id_3;

        $public_path   = public_path() . '/images/version_photos/originalImage/' . $image->original_image;
        $imageDPI = new \Imagick($public_path);
        $imageWidth = $imageDPI->getImageWidth();
        $imageHeight = $imageDPI->getImageHeight();

        $dpi = $imageDPI->getImageResolution();
        $horizontalDPI = $dpi['x'];
        $verticalDPI = $dpi['y'];

        $categoryName   = '';

        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();


        $nextID = VersionPhoto::where('status', 'on')
        ->where(function($query) use ($categoryId) {
            $query->where('category_id', $categoryId)
                ->orWhere('category_id_2', $categoryId)
                ->orWhere('category_id_3', $categoryId);
        })
        ->orderBy('created_at', 'desc')
        ->where('id', '>', $image_id)
        ->min('id');

        $previousID  = VersionPhoto::where('status', 'on')
        ->where(function($query) use ($categoryId) {
            $query->where('category_id', $categoryId)
                ->orWhere('category_id_2', $categoryId)
                ->orWhere('category_id_3', $categoryId);
        })
        ->orderBy('created_at', 'desc')
        ->where('id', '<', $image_id)
        ->max('id');


        return view('web.products.singleImage2', compact('categories' ,'image','imageWidth' ,'imageHeight' ,'nextID' ,'previousID',
        'horizontalDPI', 'verticalDPI', 'category_id', 'categoryName','categoryId'));
    }

    public function pagesAbout()

    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.about', compact('categories', 'subcategory'));
    }
    public function pagesContact()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.contact', compact('categories', 'subcategory'));
    }
    public function pagesCopyright()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.copyright', compact('categories', 'subcategory'));
    }
    public function pagesLisence()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.lisence', compact('categories', 'subcategory'));
    }
    public function pagesPrivacy()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.privacy', compact('categories', 'subcategory'));
    }
}
