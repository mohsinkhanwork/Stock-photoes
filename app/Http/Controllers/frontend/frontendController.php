<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;

class frontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $categories = Category::with('subcategory')->get();

        $subcategories = SubCategory::all();

        return view('web.home', compact('categories', 'subcategories'));

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
        // dd($categoryId);

        $categories = Category::with('subcategory')->get();

        $subcategories = SubCategory::where('category_id', $categoryId)->get();

        // dd($subcategories);



        return view('web.products.collection', compact('categories', 'subcategories','categoryName'));

    }
    public function singleImage(Request $request, $subcateid)
    {

        $categories = Category::with('subcategory')->get();
        $subcategory = SubCategory::where('id', $subcateid)->get();

        // dd($subcategories);


        return view('web.products.singleImage', compact('categories', 'subcategory'));
    }

    public function pagesAbout()
    {
        return view('web.products.about');
    }
    public function pagesContact()
    {
        return view('web.products.contact');
    }
    public function pagesCopyright()
    {
        return view('web.products.copyright');
    }
    public function pagesLisence()
    {
        return view('web.products.lisence');
    }
    public function pagesPrivacy()
    {
        return view('web.products.privacy');
    }
}
