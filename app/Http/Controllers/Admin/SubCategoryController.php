<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SubCategory;
use Illuminate\Support\Facades\DB;
use Image;
use response;
use Imagick;
use App\User;
use App\Category;
use DataTables;
use Illuminate\Support\Facades\Validator;


class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->session_name = "logo_table";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::all();
        User::clearSession($this->session_name);
        $this->return_array['page_length'] = -1;
        $this->return_array['columns'] = array(
            'consecutive' => array(
                'name' => '#',
                'sort' => false,
            ),
            'id' => array(
                'name' => 'Sub-ID',
                'sort' => true,
            ),
            'status' => array(
                'name' => 'Aktiv?',
                'sort' => false,
            ),
            'name' => array(
                'name' => 'Name',
                'sort' => false,
            ),
            'category_id' => array(
                'name' => 'Übergeordnete Kategorie',
                'sort' => false,
            ),
            'sort' => array(
                'name' => 'Sortierung',
                'sort' => true,
            ),
            'action' => array(
                'name' => 'Aktion',
                'sort' => false,
            ),
        );
        return view('admin.subcategories.index', compact('subcategories'))->with($this->return_array);
    }

    public function deleteLogoProcessSub(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        SubCategory::deleteLogo($request->id);
        return redirect()->back()->with('message', __('admin-logo.deleteLogoSuccessMessage'));
    }

    public function getDeleteLogoModaSub(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = __('admin-logo.deleteLogoModalTitle');
        $return_array['id'] = $request->id;
        return (string)view('logo-admin.delete-logo-modal-sub')->with($return_array);
    }

    public function sortLogosub(Request $request)
    {
        $this->validate($request, [
            'mode' => 'required',
            'id' => 'required',
        ]);

        SubCategory::sortLogo($request->mode, $request->id);
        return response()->json(['error' => 0, 'message' => 'done']);
    }

    public function getAllSubCatJson(Request $request)
    {
        $lastSorting = SubCategory::getLastSortNumber();
        $firstSorting = SubCategory::getFirstSortNumber();
            return Datatables::of(SubCategory::query())
                    ->addColumn('consecutive', function($row){
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->editColumn('id', function ($row) {
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 'active' ) {
                            return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-check-circle" style="font-size: 20px;color: #67b100;"></i></p>';
                        } else {
                            return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-times-circle" style="font-size: 20px;color: #ff0000b5;"></i></p>';
                        }
                    })
                    ->editColumn('name', function($row){
                        return '<p style="margin: 0px">' . $row->name . '</p>';
                    })
                    ->editColumn('category_id', function($row){
                        return '<p style="margin: 0px">' . $row->Category->name . '</p>';
                    })
                    ->editColumn('sort', function ($row) use ($lastSorting, $firstSorting) {
                        $arrowUp = "";
                        $arrowDown = "";
                        if ($row->sort != $firstSorting) {
                            $arrowUp = '<i data-url="' . route('sort-logo-sub') . '" class="fas fa-arrow-circle-up sort" data-mode="up" data-sort="' . $row->sort . '" data-id="' . $row->id . '" style="font-size: 20px;cursor: pointer;"></i>&nbsp;&nbsp;';
                        }
                        if ($row->sort != $lastSorting) {
                            $arrowDown = '<i data-url="' . route('sort-logo-sub') . '" style="font-size: 20px;cursor: pointer;" data-mode="down" data-sort="' . $row->sort . '" data-id="' . $row->id . '" class="sort fas fa-arrow-circle-down"></i>';
                        }
                        return $arrowUp . $arrowDown;
                    })
                    ->addColumn('action', function ($row) {
                        return '
                        <a href="' . route('admin.edit.subcategories', [$row->id]) . '"
                        style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                        <label data-href="' . route('get-delete-logo-modal-sub') . '"
                        data-id="' . $row->id . '"
                        data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>';

                    })
                    ->rawColumns([
                        'id',
                        'consecutive',
                        'status',
                        'name',
                        'category_id',
                        'sort',
                        'action',
                        ])
                    ->make(true);

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
        // $this->validate($request,[
        //     'image'=>'required|image|mimes:jpeg,png,jpg,gif',
        //  ]);

        $image = new SubCategory();

        if($request->input('status') == 'on'){
            $image->status = 'active';
        }
        $image->sort = (SubCategory::getLastSortNumber() + 1);
        $image->name = $request->name;
        $image->image_title = $request->image_title;
        $image->category_id = $request->category_id;
        $image->image_price = $request->image_price;


        // pick logo from local folder

    //     if ($request->file('image')) {

    //     $uploadedimagepicklogo = $request->file('image');
    //     $inputResized['image'] = time().$uploadedimagepicklogo->getClientOriginalName();
    //     // $watermark = $request->file('watermark');
    //     // $watermark1['watermark'] = time().$watermark->getClientOriginalName();
    //     $imgFile = Image::make($uploadedimagepicklogo->getRealPath())->resize(500, 675);       //image resize from here;
    //     $watermark = Image::make(public_path('frontend/img/logo.png'))->resize(440, 90)->opacity(50);   // watermark resize from here
    //     // $watermark = Image::make($watermark->getRealPath())->opacity(50);   // watermark resize from here
    //     $path = storage_path('app/public/subcategories').'/'.$inputResized['image'];
    //     $imgFile->insert($watermark, 'center')->save($path);
    //     $image->image =  $inputResized['image'];

    //     // // end pick logo from local

    //     // // single image start

    //     $uploadedimagesingle = $request->file('image');
    //     $inputsingle['image'] = time().$uploadedimagesingle->getClientOriginalName();
    //     // $watermark = $request->file('watermark');
    //     // $watermark1['watermark'] = time().$watermark->getClientOriginalName();
    //     $imgFilesingle = Image::make($uploadedimagesingle->getRealPath())->resize(1024, 768);       //image resize from here;
    //     $watermarksingle = Image::make(public_path('frontend/img/logo.png'))->resize(440, 90)->opacity(50);   // watermark resize from here
    //     $pathsingle = storage_path('app/public/subcategories').'/'.$inputsingle['image'];
    //     $imgFilesingle->insert($watermarksingle, 'center')->save($pathsingle);
    //     $image->image_singlePage =  $inputsingle['image'];

    //     // // end single image



    //     // // original image

    //     $uploadedoriginalImage = $request->file('image');

    //     $originalinput['image'] = time().$uploadedoriginalImage->getClientOriginalName();
    //     $imgFileoriginal = Image::make($uploadedoriginalImage->getRealPath());       // original image
    //     $pathoriginal = storage_path('app/public/subcategories').'/'.$originalinput['image'];
    //     $imgFileoriginal->save($pathoriginal);
    //     $height = Image::make($uploadedoriginalImage)->height();      // height of the original image
    //     $width = Image::make($uploadedoriginalImage)->width();
    //     $image->originalImage = $originalinput['image'];
    //     $image->height =  $height;
    //     $image->width =  $width;
    //     // end original image


    //     // resoltuion of images
    //     $uploadedoriginalImageresol = $request->file('image');
    //     $originalinputresolution['image'] = time().$uploadedoriginalImageresol->getClientOriginalName();
    //     $imgFileoriginalreso = Image::make($uploadedoriginalImageresol->getRealPath())->resize(900, 675);       // original image
    //     $watermark = Image::make(public_path('frontend/img/logo.png'))->resize(440, 90)->opacity(50);   // watermark resize from here
    //     $pathoriginalresolution = storage_path('app/public/subcategories').'/'.$originalinputresolution['image'];
    //     $imgFileoriginalreso->insert($watermark, 'center')->save($pathoriginalresolution);
    //     $imgFileoriginalreso->save($pathoriginalresolution);
    //     $imagick = new Imagick($pathoriginalresolution);

    //     $imagick->setImageResolution(72,72) ; // it change only image density.

    //     // $getimagreso = $imagick->getImageResolution();
    //     // dd($getimagreso['x']);
    //     // dd($getimagreso['y']);

    //     $saveImagePath = storage_path('app/public/subcategories/96dpiImagesForSub') . '/' . $originalinputresolution['image'];
    //     $imagick->writeImages($saveImagePath, true);

    //     $image->dpiImage = $originalinputresolution['image'];
    //     // end resol of images

    // }

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

        // $this->validate($request,[
        //     'image'=>'required|image|mimes:jpeg,png,jpg,gif',
        //  ]);


        $image = SubCategory::find($request->id);
        $image->name = $request->name;
        if($request->input('status') == 'on'){
            $image->status = 'active';
        }
        $image->sort = $request->sort;
        $image->image_title = $request->image_title;
        $image->category_id = $request->category_id;
        $image->image_price = $request->image_price;

        //

        // pick logo from local folder

    //     if ($request->file('image')) {

    //     $uploadedimagepicklogo = $request->file('image');
    //     $inputResized['image'] = time().$uploadedimagepicklogo->getClientOriginalName();
    //     // $watermark = $request->file('watermark');
    //     // $watermark1['watermark'] = time().$watermark->getClientOriginalName();
    //     $imgFile = Image::make($uploadedimagepicklogo->getRealPath())->resize(540, 405);       //image resize from here;
    //     $watermark = Image::make(public_path('frontend/img/logo.png'))->resize(440, 90)->opacity(50);   // watermark resize from here
    //     // $watermark = Image::make($watermark->getRealPath())->opacity(50);   // watermark resize from here
    //     $path = storage_path('app/public/subcategories').'/'.$inputResized['image'];
    //     $imgFile->insert($watermark, 'center')->save($path);
    //     $image->image =  $inputResized['image'];

    //     // end pick logo from local



    //     // single image start

    //     $uploadedimagesingle = $request->file('image');
    //     $inputsingle['image'] = time().$uploadedimagesingle->getClientOriginalName();
    //     // $watermark = $request->file('watermark');
    //     // $watermark1['watermark'] = time().$watermark->getClientOriginalName();
    //     $imgFilesingle = Image::make($uploadedimagesingle->getRealPath())->resize(1024, 768);       //image resize from here;
    //     $watermarksingle = Image::make(public_path('frontend/img/logo.png'))->resize(440, 90)->opacity(50);   // watermark resize from here
    //     $pathsingle = storage_path('app/public/subcategories').'/'.$inputsingle['image'];
    //     $imgFilesingle->insert($watermarksingle, 'center')->save($pathsingle);
    //     $image->image_singlePage =  $inputsingle['image'];


    //     // end single image


    //       // // original image

    //       $uploadedoriginalImage = $request->file('image');
    //       $originalinput['image'] = time().$uploadedoriginalImage->getClientOriginalName();
    //       $imgFileoriginal = Image::make($uploadedoriginalImage->getRealPath());       // original image
    //       $pathoriginal = storage_path('app/public/subcategories').'/'.$originalinput['image'];
    //       $imgFileoriginal->save($pathoriginal);
    //       $height = Image::make($uploadedoriginalImage)->height();      // height of the original image
    //       $width = Image::make($uploadedoriginalImage)->width();
    //       $image->originalImage = $originalinput['image'];
    //       $image->height =  $height;
    //       $image->width =  $width;

    //     // end original image


    //    // resoltuion of images
    //    $uploadedoriginalImageresol = $request->file('image');
    //    $originalinputresolution['image'] = time().$uploadedoriginalImageresol->getClientOriginalName();
    //    $imgFileoriginalreso = Image::make($uploadedoriginalImageresol->getRealPath())->resize(900, 675);       // original image
    //    $watermark = Image::make(public_path('frontend/img/logo.png'))->resize(440, 90)->opacity(50);   // watermark resize from here
    //    $pathoriginalresolution = storage_path('app/public/subcategories').'/'.$originalinputresolution['image'];
    //    $imgFileoriginalreso->insert($watermark, 'center')->save($pathoriginalresolution);
    //    $imgFileoriginalreso->save($pathoriginalresolution);
    //    $imagick = new Imagick($pathoriginalresolution);

    //    $imagick->setImageResolution(72,72) ; // it change only image density.

    //    // $getimagreso = $imagick->getImageResolution();
    //    // dd($getimagreso['x']);
    //    // dd($getimagreso['y']);

    //    $saveImagePath = storage_path('app/public/subcategories/96dpiImagesForSub') . '/' . $originalinputresolution['image'];
    //    $imagick->writeImages($saveImagePath, true);

    //    $image->dpiImage = $originalinputresolution['image'];
    //    // end resol of images
    //     }

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

