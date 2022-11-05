<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Photo;


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

        // $subcategories = SubCategory::all();
        // $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();


        return view('web.home', compact('categories'));

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

    public function collections(Request $request, $categoryId, $categoryName)
    {

        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();
        //get all photos of this category with latest added first and paginate
        $latestPhotos  = Photo::where('category_id', $categoryId)->orderBy('created_at', 'desc')->paginate(12);
        // dd($latestPhotos);

        return view('web.products.collection', compact('categories', 'latestPhotos' , 'categoryId' ,'subcategories','categoryName'));

    }
    //function for photo_collections
    public function photo_collections(Request $request, $categoryId, $categoryName, $subcategoryId, $subcategoryName)
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();
        //get all photos of this category with latest added
        $latestPhotos = Photo::where('category_id', $categoryId)->where('sub_category_id', $subcategoryId)->orderBy('created_at', 'desc')->paginate(12);
        //if latestPhotos is empty then show message
        if($latestPhotos->isEmpty()){
            $message = "Keine Fotos gefunden";
        }else{
            $message = "";
        }

        return view('web.products.photo_collection', compact('categories', 'message' ,'latestPhotos' , 'categoryId' ,'subcategories','categoryName', 'subcategoryName'));

    }
    public function singleImage(Request $request, $categoryId,$subcategoryId, $image_id)
    {
        // dd($image_id, $categoryId, $subcategoryId);
        $image         = Photo::where('id', $image_id)->orderBy('created_at', 'desc')->first();
        $category     = Category::with('subcategory')
        ->where('id', $image->category_id)->first();
        // dd($category);
        $subcategory    = SubCategory::where('id', $image->sub_category_id)->first();
        // dd($subcategory);

        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategoris = SubCategory::all();
        //get all images based on category id
        $images = Photo::where('category_id', $categoryId)->where('sub_category_id', $subcategoryId)->get();
        // dd($images);

        return view('web.products.singleImage', compact('category', 'subcategory', 'categories' ,'image', 'images' ,'subcategoris'));
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
