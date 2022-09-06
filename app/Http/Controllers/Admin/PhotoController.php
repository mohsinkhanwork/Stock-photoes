<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Photo;
use App\User;
use Intervention\Image\Facades\Image;
use response;
use Imagick;
use Yajra\Datatables\Datatables;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class PhotoController extends Controller
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
    public function index(Request $request, $category_name = null)
    {
        if ($category_name == null) {
            $categories = Category::all();
        } else {
            $categories = Category::where('name','!=',$category_name)->get();
        }

        User::clearSession($this->session_name);
        $this->return_array['page_length'] = -1;
        $this->return_array['columns'] = array(
            'consecutive' => array(
                'name' => '#',
                'sort' => false,
            ),
            'id' => array(
                'name' => 'Photo-ID',
                'sort' => true,
            ),
            'image' => array(
                'name' => 'Bild',
                'sort' => false,
            ),
            'status' => array(
                'name' => 'Aktiv?',
                'sort' => false,
            ),
            'description' => array(
                'name' => 'Beschreibung',
                'sort' => false,
            ),
            'category_id' => array(
                'name' => 'Kategorie',
                'sort' => false,
            ),
            'sub_category_id' => array(
                'name' => 'Unterkategorie',
                'sort' => false,
            ),
            'created_at' => array(
                'name' => 'hochgeladenes Datum',
                'sort' => false,
            ),
            'action' => array(
                'name' => 'Aktion',
                'sort' => false,
            ),
        );

        return view('admin.photos.index', compact('categories', 'category_name'))->with($this->return_array);
    }

    public function getAllPhotos(Request $request)
    {
        // if ($request->has('value')) {
        //     dd($request->has('value'));
        // }

        // // jo searched kya uska category ka id
        $category_id = Category::where('name', $request->search['value'])->value('id');
        $category_name = $request->search['value'];
        $all_photos = Photo::query()->where('category_id', $category_id)->get();
        // dd($all_photos);

            return Datatables::of($all_photos)
                    ->addColumn('consecutive', function($row){
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->editColumn('id', function ($row) {
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 'on' ) {
                            return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-check-circle" style="font-size: 20px;color: #67b100;"></i></p>';
                        } else {
                            return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-times-circle" style="font-size: 20px;color: #ff0000b5;"></i></p>';
                        }
                    })
                    ->addColumn('image', function ($row) {
                        return '<div style="text-align:center; padding-left:7px;">
                        <img src="' . asset('/storage/photos/thumbnail/'.$row->small_thumbnail) . '" style="object-fit: cover;width: 50px;height:50px; margin-top:5px; margin-bottom:3px;"/>
                        </div>';
                    })
                    ->addColumn('description', function($row){
                        return '<p style="margin: 0px">' . $row->description . '</p>';
                    })
                    ->editColumn('category_id', function($row){

                        return '<p style="margin: 0px">' . $row->Category->name . '</p>';
                    })
                    ->editColumn('sub_category_id', function($row){
                        if($row->subcategory == null) {
                            return 'Keine Unterkategorie definiert';
                        } else {
                        return '<p style="margin: 0px">' . $row->subcategory->name . '</p>';

                        }
                    })
                    ->addColumn('created_at', function($row){
                        return '<p style="margin: 0px">' . $row->created_at . '</p>';
                    })
                    ->addColumn('action', function ($row) use ($category_name) {
                        return '
                        <a href="' . url('admin/edit/photos', ['id' => $row->id, 'category_name' => $category_name ]) . '"
                        style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                        <label data-href="' . route('get-delete-modal-photo') . '"
                        data-id="' . $row->id . '"
                        data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>';

                    })
                    ->rawColumns([
                        'id',
                        'consecutive',
                        'status',
                        'description',
                        'created_at',
                        'category_id',
                        'image',
                        'sub_category_id',
                        'action',
                        ])
                    ->make(true);

    }

    public function getDeleteLogoModaPhoto(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = __('admin-logo.deleteLogoModalTitle');
        $return_array['id'] = $request->id;
        $photo_description = Photo::where('id', $return_array['id'])->value('description');
        $return_array['name'] = $photo_description;
        return (string)view('logo-admin.delete-modal-photo')->with($return_array);
    }

    public function deleteLogoProcessPhoto(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        Photo::deleteLogo($request->id);
        return redirect()->back()->with('success','Foto erfolgreich gelöscht');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCatName(Request $request, $name)
    {
        return response()->json(['name' => $name]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $name)
    {

        $category_name = $request->name;
        // dd($category_name);
        $categories = DB::table('categories')->where('name', $category_name)->first();
        $category_id = $categories->id;
        $sub_categories = SubCategory::with('category')
        ->where('category_id',$category_id)
        ->get()->pluck('name', 'id')->prepend('Wählen Sie', '');

        return view('admin.photos.create', compact('category_id', 'category_name', 'sub_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7048',
            'description' => 'required'
        ]);

        if($request->hasfile('image'))
         {
            // foreach($request->file('image') as $image)
            // {
                $image = $request->file('image');
                $ImageNameresized= time().$image->getClientOriginalName();
                $imgFileCollection = Image::make($image->getRealPath())->resize(888, 666);       //image resize from here;
                $watermark = Image::make(public_path('frontend/img/logo.png'))->resize(440, 90)->opacity(50);
                $pathOfOriginalImage = storage_path('/app/public/photos/') . '/' . $ImageNameresized;
                $imgFileCollection->insert($watermark, 'center')->save($pathOfOriginalImage);
                // $data[] = $ImageNameCollection;
            // }

            //upload file for small thmbnails
            $filenamewithextension = $image->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //get extension
            $extension = $image->getClientOriginalExtension();
            //filename to store
            $smallfilenametostore = $filename.'_small_'.time().'.'.$extension;
            //resize image in storage
            $smallthumbnailpath = storage_path('/app/public/photos/thumbnail') . '/' . $smallfilenametostore;
            $smallthumbnail = Image::make($image->getRealPath())->resize(150, 93);
            $smallthumbnail->save($smallthumbnailpath);


            //upload file without watermark and original image
            $ImageNameOriginal= time().$image->getClientOriginalName();
            $imgFileOriginal = Image::make($image->getRealPath());       //image resize from here;
            $pathOfCollectionImage = storage_path('/app/public/photos/originalImage') . '/' . $ImageNameOriginal;
            $imgFileOriginal->save($pathOfCollectionImage);




         }

        $form                  =    new Photo();
        $form->status          =    $request->status;
        $form->description     =    $request->description;
        $form->sub_category_id =    $request->sub_category_id;
        $form->category_id     =    $request->category_id;
        // $form->image=json_encode($data); //collection images
        $form->image           =    $ImageNameresized; //collection images
        //save small_thumbnail image name in database
        $form->small_thumbnail =    $smallfilenametostore;
        //save original_image name in database
        $form->original_image  =    $ImageNameOriginal;

        $categories = DB::table('categories')->where('id', $request->category_id)->first();
        $category_name = $categories->name;

        $form->save();


        return redirect()->route('admin.photos', [$category_name])
        ->with('success', 'Ihre Bilder wurden erfolgreich hinzugefügt');
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
    public function edit(Request $request, $photo_id, $category_name)
    {
        $categories = DB::table('categories')->where('name', $category_name)->first();
        $category_id = $categories->id;
        $category_name = $categories->name;
        // dd($category_name);
        $photo = Photo::findOrfail($photo_id);
        $sub_categories = SubCategory::with('category')
        ->where('category_id',$category_id)
        ->get()->pluck('name', 'id')->prepend('Wählen Sie', '');
        return view('admin.photos.edit', compact('photo', 'sub_categories' ,'category_id', 'category_name'));
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
        $this->validate($request, [
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7048',
            'description' => 'required',
        ]);

        $photo                  = Photo::find($request->id);
        $photo->description     = $request->description;
        $photo->category_id     = $request->category_id;
        $photo->sub_category_id = $request->sub_category_id;

        if($request->input('status') == 'on')
        {
            $photo->status = 'on';
        } else {
            $photo->status = '';
        }

        if($request->hasfile('image') && $request->image != '')
        {
            $image_path = storage_path('/app/public/photos/') . '/' . $photo->image;
            //image path for small thumbnail
            $small_thumbnail_path = storage_path('/app/public/photos/thumbnail') . '/' . $photo->small_thumbnail;
            //image path for original image
            $original_image_path = storage_path('/app/public/photos/originalImage') . '/' . $photo->original_image;
            //if file exists delete multiple images
            if(File::exists($image_path) && File::exists($small_thumbnail_path) && File::exists($original_image_path)) {
                File::delete($image_path);
                File::delete($small_thumbnail_path);
                File::delete($original_image_path);
            }

            $image = $request->file('image');
            $ImageNameCollection= time().$image->getClientOriginalName();
            $imgFileCollection = Image::make($image->getRealPath())->resize(888, 666);       //image resize from here;
            $watermark = Image::make(public_path('frontend/img/logo.png'))->resize(440, 90)->opacity(50);
            $pathCollection = storage_path('/app/public/photos/') . '/' . $ImageNameCollection;
            $imgFileCollection->insert($watermark, 'center')->save($pathCollection);




           //upload file for small thmbnails
           $filenamewithextension = $image->getClientOriginalName();
           $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
           //get extension
           $extension = $image->getClientOriginalExtension();
           //filename to store
           $smallfilenametostore = $filename.'_small_'.time().'.'.$extension;
           //resize image in storage
           $smallthumbnailpath = storage_path('/app/public/photos/thumbnail') . '/' . $smallfilenametostore;
           $smallthumbnail = Image::make($image->getRealPath())->resize(150, 93);
           $smallthumbnail->save($smallthumbnailpath);

           //upload file without watermark and original image
           $ImageNameOriginal= time().$image->getClientOriginalName();
           $imgFileOriginal = Image::make($image->getRealPath());       //image resize from here;
           $pathOfCollectionImage = storage_path('/app/public/photos/originalImage') . '/' . $ImageNameOriginal;
           $imgFileOriginal->save($pathOfCollectionImage);
        }

        $photo->image           =    $ImageNameCollection;
        //update small_thumbnail image name in database
        $photo->small_thumbnail =    $smallfilenametostore;
        //update original_image name in database
        $photo->original_image  =    $ImageNameOriginal;
        $categories = DB::table('categories')->where('id', $request->category_id)->first();
        $category_name          =    $categories->name;


        $photo->update();
        return redirect()->route('admin.photos', [$category_name])
        ->with('success', 'Bild wurde erfolgreich aktualisiert');
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
}
