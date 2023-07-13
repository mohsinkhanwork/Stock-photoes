<?php

namespace App\Http\Controllers\Admin;

// Add your error reporting lines here
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Photo;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Datatables;
use App\Category;
use App\SubCategory;
use App\VersionPhoto;
use Illuminate\Support\Facades\Redirect;
use App\Services\PhotoService;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;

class PhotoController extends Controller
{
    protected $photoService;
    public $return_array;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category_name = null)
    {
        if ($category_name == null) {
            $categories = Category::orderBy('sort', 'asc')->get();
        } else {
            $categories = Category::where('name','!=',$category_name)
            ->orderBy('sort', 'asc')
            ->get();
        }

        $sub_categories = SubCategory::all();

        $this->return_array['page_length'] = -1;
        $this->return_array['columns'] = array(
            'consecutive' => array(
                'name' => '#',
                'sort' => false,
            ),
            'id' => array(
                'name' => 'Foto-ID',
                'sort' => true,
            ),
            'image' => array(
                'name' => 'Foto',
                'sort' => false,
            ),
            'description' => array(
                'name' => 'Titel',
                'sort' => true,
            ),


            //  'sub_category_id' => array(
            //     'name' => 'Unterkategorie',
            //     'sort' => false,
            // ),


            'Version Aktiv' => array(
                // 'name' => 'Kategorie',
                'name' => 'Version',
                'sort' => false,
            ),



            'status' => array(
                'name' => 'Aktiv',
                'sort' => false,
            ),

            'created_at' => array(
                'name' => 'Hinzugefügt',
                'sort' => false,
            ),
            'action' => array(
                'name' => 'Aktion',
                'sort' => false,
            ),
        );

        return view('admin.photos.index', compact('categories', 'category_name', 'sub_categories'))->with($this->return_array);
    }

    public function getAllPhotos(Request $request)
    {
        $category_name = $request->search['value'];
        $category_id = null; // Initialize with null
        $subCatID = $request->search['subCategory'];

        if ($category_name) {
            $category_id = Category::where('name', $category_name)->value('id');
        }

        if ($category_id) {
            $all_photos = Photo::with(['getVersions' => function ($query) use ($category_id, $subCatID) {
                    $query->where('category_id', $category_id)
                        ->orWhere('category_id_2', $category_id)
                        ->orWhere('category_id_3', $category_id);

                    // Check if subCatID is not null before adding conditions for it
                    if ($subCatID) {
                        $query->where(function ($query) use ($subCatID) {
                            $query->where('sub_category_id', $subCatID)
                                ->orWhere('sub_category_id_2', $subCatID)
                                ->orWhere('sub_category_id_3', $subCatID);
                        });
                    }
                }])
                ->whereHas('getVersions', function ($query) use ($category_id, $subCatID) {
                    $query->where('category_id', $category_id)
                        ->orWhere('category_id_2', $category_id)
                        ->orWhere('category_id_3', $category_id);

                    // Check if subCatID is not null before adding conditions for it
                    if ($subCatID) {
                        $query->where(function ($query) use ($subCatID) {
                            $query->where('sub_category_id', $subCatID)
                                ->orWhere('sub_category_id_2', $subCatID)
                                ->orWhere('sub_category_id_3', $subCatID);
                        });
                    }
                })
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $all_photos = collect([]); // Create an empty collection if either category_id or subCatID is missing
        }

            return Datatables::of($all_photos)
                    ->editColumn('id', function ($row) {
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->addColumn('consecutive', function($row){
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->addColumn('image', function ($row) {
                        $versionPhoto = $row->getVersions->where('status', 'on')->first();
                        $thumbnail = $versionPhoto->small_thumbnail;
                        $imagePath = 'images/version_photos/thumbnail/';

                    return '<div style="text-align:center; padding-left:7px;height: 58px;">
                        <label data-href="' . route('get-modal-photo') . '"
                        data-id="' . $versionPhoto->id . '"
                        data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal">
                        <img src="' . asset($imagePath . $thumbnail) . '" style="margin-top:5px;margin-bottom:3px;max-height: 50px;max-width: 100%;"/></label>
                        </div>';
                    })
                    ->addColumn('description', function($row){
                        return '<p style="margin: 0px">' . $row->title . '</p>';
                    })

                    //new work
                    ->addColumn('Version Aktiv', function($row) {
                        $count_color_C = VersionPhoto::where('photo_id', $row->id)->where('color_create_version', 'C')->count();
                        $count_color_C = $count_color_C < 10 ? 'C 0' . $count_color_C : $count_color_C;
                        $count_color_B = VersionPhoto::where('photo_id', $row->id)->where('color_create_version', 'B')->count();
                        $count_color_B = $count_color_B < 10 ? 'B 0' . $count_color_B : $count_color_B;
                        $count_color_S = VersionPhoto::where('photo_id', $row->id)->where('color_create_version', 'S')->count();
                        $count_color_S = $count_color_S < 10 ? 'S 0' . $count_color_S : $count_color_S;

                        $result = '';
                        if ($count_color_C == 'C 00' || $count_color_C == 'C 0') {
                            $result .= '<p style="margin: 0px; color: transparent;">.</p>';
                        } else {
                            $result .= '<p style="margin: 0px;">' . $count_color_C .'</p>';
                        }

                        if ($count_color_B == '0' || $count_color_B == 'B 00' || $count_color_B == 'B 0') {
                            $result .= '<p style="margin: 0px;color: transparent;"">.</p>';
                        } else {
                            $result .= '<p style="margin: 0px;">' . $count_color_B .'</p>';
                        }

                        if ($count_color_S == 'S 00' || $count_color_S == 'S 0') {
                            $result .= '<p style="margin: 0px; color: transparent;">.</p>';
                        } else {
                            $result .= '<p style="margin: 0px;">' . $count_color_S .'</p>';
                        }

                        return $result;


                    })
                    //end new work


                    //new work
                    ->addColumn('status', function ($row) {

                    $latest_color_version = VersionPhoto::where('photo_id', $row->id)->where('color_create_version', 'C')
                    ->first();
                    $latest_black_version = VersionPhoto::where('photo_id', $row->id)->where('color_create_version', 'B')
                    ->first();
                    $latest_sepia_version = VersionPhoto::where('photo_id', $row->id)->where('color_create_version', 'S')
                    ->first();


                    return '<p style="text-align:center; margin-bottom:0px;">
                    <i class="fa fa-check-circle " style="font-size: 15px;color: ' . (isset($latest_color_version->status) ? '#67b100'
                    : ( isset($latest_color_version->status) ? '#ff0000b5' : 'rgba(255, 255, 255, 0)')) .
                    ';"></i>
                    </p>
                    <p style="text-align:center; margin-bottom:0px;">
                    <i class="fa fa-check-circle" style="font-size: 15px;color: ' . ( isset($latest_black_version) ? '#67b100'
                    : (isset($latest_black_version) ? '#ff0000b5' : 'rgba(255, 255, 255, 0)')) .
                    ';"></i>
                    </p>
                    <p style="text-align:center; margin-bottom:0px;">
                    <i class="fa fa-check-circle" style="font-size: 15px;color: ' . ( isset($latest_sepia_version) ? '#67b100'
                    : ( isset($latest_sepia_version) ? '#ff0000b5' : 'rgba(255, 255, 255, 0)')) .
                    ';"></i>
                    </p>'
                    ;
                    })
                    //end new work


                    //old work
                    // ->addColumn('status', function ($row) {
                    //     if ($row->status == 'on' ) {
                    //         return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-check-circle" style="font-size: 20px;color: #67b100;"></i></p>';
                    //     } else {
                    //         return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-times-circle" style="font-size: 20px;color: #ff0000b5;"></i></p>';
                    //     }
                    // })
                    //end old work


                    //new work
                    ->addColumn('created_at', function($row){
                        $null_color = VersionPhoto::where('photo_id', $row->id)
                        ->where('color_create_version', 'C')
                        ->orderBy('created_at', 'desc')
                        ->value('created_at');
                        $null_color = $null_color == null ? 'none' : $null_color;

                        $null_black = VersionPhoto::where('photo_id', $row->id)
                        ->where('color_create_version', 'B')
                        ->orderBy('created_at', 'desc')
                        ->value('created_at');
                        $null_black = $null_black == null ? 'none' : $null_black;

                        $null_sepia = VersionPhoto::where('photo_id', $row->id)
                        ->where('color_create_version', 'S')
                        ->orderBy('created_at', 'desc')
                        ->value('created_at');
                        $null_sepia = $null_sepia == null ? 'none' : $null_sepia;

                        $checkmark_circle = '<span style="color: #dee2e6">.</span>';

                        return '<p style="margin-bottom: 0px">' . ($null_color == 'none' ? '' : $checkmark_circle) . '<span style="color: ' . ($null_color == 'none' ? 'transparent' : '')
                        . ';">' . $null_color . '</span></p>
                        <p style="margin-bottom: 0px">' . ($null_black == 'none' ? '' : $checkmark_circle) . '<span style="color: ' . ($null_black == 'none' ? 'transparent' : '') . ';">' . $null_black . '</span></p>
                        <p style="margin-bottom: 0px">' . ($null_sepia == 'none' ? '' : $checkmark_circle) . '<span style="color: ' . ($null_sepia == 'none' ? 'transparent' : '') . ';">' . $null_sepia . '</span></p>';
                        })
                    //end new work


                    //old work

                    // ->addColumn('created_at', function($row){
                    //     return '<p style="margin: 0px">' . $row->created_at . '</p>';
                    // })

                    //end old work


                    //new work
                    ->addColumn('action', function ($row) use ($category_name, $subCatID) {
                        $color_exists = VersionPhoto::where('photo_id', $row->id)
                                        ->where('color_create_version', 'C')
                                        ->exists();

                        $black_exists = VersionPhoto::where('photo_id', $row->id)
                                        ->where('color_create_version', 'B')
                                        ->exists();

                        $sepia_exists = VersionPhoto::where('photo_id', $row->id)
                                        ->where('color_create_version', 'S')
                                        ->exists();

                        $color_link = $color_exists ?
                                        '<p style="margin: 0px"><a href="' . url('admin/edit/photos/'. $category_name . '/' .  $row->id .  '/' . $subCatID . '#Farbe') . '" style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a></p>' :
                                        '<p style="margin: 0px; color: transparent">none</p>';

                        $black_link = $black_exists ?
                                        '<p style="margin: 0px"><a href="' . url('admin/edit/photos/'. $category_name .  '/'.  $row->id . '/' . $subCatID . '#color') . '" style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a></p>' :
                                        '<p style="margin: 0px; color: transparent">none</p>';

                        $sepia_link = $sepia_exists ?
                                        '<p style="margin: 0px"><a href="' . url('admin/edit/photos/'. $category_name .  '/' . $row->id . '/' . $subCatID . '#Sepia') . '" style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a></p>' :
                                        '<p style="margin: 0px; color: transparent">none</p>';

                        return $color_link . $black_link . $sepia_link;
                    })


                    //end new work

                    //old work
                    // ->addColumn('action', function ($row) use ($category_name) {
                    //     return '
                    //     <a href="' . url('admin/edit/photos', ['id' => $row->id, 'category_name' => $category_name ]) . '"
                    //     style="cursor: pointer;color: black; display: none;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                    //     <label data-href="' . route('get-delete-modal-photo') . '"
                    //     data-id="' . $row->id . '"
                    //     data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>';

                    // })
                    //end old work

                    ->rawColumns([
                        'consecutive',
                        'id',
                        'status',
                        'description',
                        'created_at',
                        'Version Aktiv',
                        'image',
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
        $category_id = Photo::where('id', $return_array['id'])->value('category_id');
        $category_name = Category::where('id', $category_id)->value('name');
        $return_array['category_name'] = $category_name;
        $return_array['name'] = $photo_description;
        return (string)view('logo-admin.delete-modal-photo')->with($return_array);
    }

     public function getLogoModaPhoto(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $VphotoId = $request->id;
        // dd($VphotoId);
        $Vphoto = VersionPhoto::where('id', $VphotoId)->first();
        // dd($Vphoto);

        return view('logo-admin.modal-photo', compact('Vphoto'));
    }

    public function deleteLogoProcessPhoto(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        Photo::deleteLogo($request->id);
        return redirect()->route('admin.photos', ['category_name' => $request->category_name])->with('success','Foto erfolgreich gelöscht');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCatName($name)
    {
        return response()->json(['name' => $name]);

    }

    public function getSubCatName($category_name=null)
    {
        $categoryId = Category::where('name', $category_name)->value('id');

        if ($categoryId) {
            $subcategories = Subcategory::where('category_id', $categoryId)->get();  // Fetch related subcategories
        } else {
            $subcategories = SubCategory::all();  // Fetch all subcategories if no such category exists or it has no subcategories
        }
        return response()->json($subcategories);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $all_categories = Category::orderBy('sort', 'asc')->get();

        return view('admin.photos.create', compact('all_categories'));
    }

    public function getSubcategoryName1($id)
        {
            $subcategory = Subcategory::find($id);

            if ($subcategory) {
                return $subcategory->name;
            } else {
                return response()->json(['error' => 'Subcategory not found'], 404);
            }
        }

        public function fetchSubcategories(Request $request)
        {
            // Get the category name from the request
            $categoryName = $request->input('category');

            // Find the category in the database
            $category = Category::where('name', $categoryName)->value('id');

            if (!$category) {
                // Return an empty array if the category doesn't exist
                return response()->json([]);
            }

            // Find the subcategories associated with the category
            $subcategories = Subcategory::where('category_id', $category)->get();

            // Return the subcategories in a JSON response
            return response()->json($subcategories);
        }

        public function allsubcategorynames()
        {
            // Assuming you have a SubCategory model
            $subcategories = SubCategory::all();

            // convert the data to a format that your front end expects
            $subcategories = $subcategories->map(function ($subcategory) {
                return [
                    'id' => $subcategory->id,
                    'name' => $subcategory->name,
                ];
            });

            return response()->json($subcategories);
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
            // 'subcategory' => 'required',
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:207048',
        ], [
            // 'subcategory.required' => 'Unterkategorie muss ausgewählt werden',
            'image.required' => 'Bild ist erforderlich',
            // 'title.required' => 'Titel muss ausgefüllt werden',
        ]);


        // dd($request->all());
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');

        // dd($category . ' ' . $subcategory);

        ini_set('max_execution_time', 3000);

        $category_id = Category::where('name', $request->category)->value('id');

        $photo                      =    new Photo();
        $photo->description         =    $request->description;
        $photo->sub_category_id     =    $request->subcategory;
        $photo->category_id         =    $category_id;
        $photo->title               =    $request->title;
        $photo->type                =    $request->type;
        $photo->OF_height           =    $request->OF_height;
        $photo->OF_width            =    $request->OF_width;
        $photo->EK_price            =    $request->EK_price;
        $photo->EK_year             =    $request->EK_year;
        $photo->weather             =    $request->weather;
        $photo->season              =    $request->season;
        $photo->image_year          =    $request->image_year;
        $photo->photographer        =    $request->photographer;
        $photo->color_create_version =    $request->color_create_version;

        $counter = 1;
        if($counter < 10){
            $counter = '0'.$counter;
        }
        $photo->counter = $counter;
        $photo->save();


        $photo_id = $photo->id;
        $photo = Photo::find($photo_id);


        if($request->hasfile('image'))
         {
            $manager = new ImageManager(['driver' => 'imagick']);
            $image                          = $request->file('image');
            $original_filename              = $image->getClientOriginalName();
            $imgFileCollection              = Image::make($image->getRealPath());
            $height_imgFileCollection       = $imgFileCollection->height();
            $width_imgFileCollection        = $imgFileCollection->width();


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
            // this is test

            $versionCounter = '01';
            $imgFileCollection->resize($width_imgFileCollection, $height_imgFileCollection, function($constraint)
            {
                $constraint->aspectRatio();

            });

            $resizedWidth = $imgFileCollection->width();
            $resizedHeight = $imgFileCollection->height();

            // Get the original DPI
            $imagick = new \Imagick();
            $imagick->readImage($image->getRealPath());
            $resolution = $imagick->getImageResolution();
            $originalDpi = $resolution['x'];

            $imageName = 'nzphotos-' . $request->color_create_version . $photo_id . $versionCounter . '-' . $resizedWidth . 'x' . $resizedHeight . '.jpg';
            $pathOfImage = public_path() . '/images/photos/';
            $imgFileCollection->save($pathOfImage . $imageName, 100);

            // Set the original DPI to the saved image
            $imagickImage = new \Imagick($pathOfImage . $imageName);
            $imagickImage->setImageResolution($originalDpi, $originalDpi);
            $imagickImage->writeImage($pathOfImage . $imageName);
            $imagickImage->destroy();
            //ends here


            // upload file for small thmbnails
            $width_smallthumbnail               = 150;
            $height_smallthumbnail              = 93;
            $imgFileCollection1                 = Image::make($image->getRealPath());
            $imageNameThumbnail                 =  'nzphotos-' . $request->color_create_version . $photo_id. $versionCounter.'-'.$width_smallthumbnail.'x'.$height_smallthumbnail.'.jpg';
            $imgFileCollection1->resize($width_smallthumbnail, $height_smallthumbnail, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $pathOfImagethumbnail            = public_path() . '/images/photos/thumbnail/';
            $imgFileCollection1->save($pathOfImagethumbnail . $imageNameThumbnail);
            //ends here

         }

        $photo->image               =    $imageName;
        $photo->small_thumbnail     =    $imageNameThumbnail;
        // $photo->original_image      =    $imageNameOriginal;
        // $photo->singleImage         =    $imageNameCIDCOUNTER;
        $photo->original_filename   =    $original_filename;
        $photo->save();


        //save a new version photo in database table from saved photo
        $photo_version              = new VersionPhoto();
        $last_version_photo         = VersionPhoto::where('photo_id', $request->photo_id)
        ->orderBy('counter', 'desc')->first();
        if(!$last_version_photo){

            $photo_version->counter = $counter;
            $photo_version->color_create_version = $photo->color_create_version;
        } else{

        }

        $versionCounter = $photo_version->counter;

            //
            $imgFileCollection3             = Image::make($image->getRealPath());

            $height                         = $imgFileCollection3->height();
            $width                          = $imgFileCollection3->width();
            if($height    > $width) {           //portrait images
                $width    = (2048/$height) * $width;

                $width    = round($width);
                $height   = 2048;


            } elseif ($width > $height) {
                $height   = (2048/$width) * $height;

                $height   = round($height);
                $width    = 2048;

            } else {
                $height   = 2048;
                $width    = 2048;
            }


            $imgFileCollection3->resize($width, $height, function($constraint)
            {
                $constraint->aspectRatio();

            });

            $resizedWidth3 = $imgFileCollection3->width();
            $resizedHeight3 = $imgFileCollection3->height();

            $imageName              =  'nzphotos-' . $request->color_create_version . $photo_id. $versionCounter.'-'.$resizedWidth3.'x'.$resizedHeight3.'.jpg';
            $pathOfImageVersionPhotos            = public_path() . '/images/version_photos/';
            $imgFileCollection3->save($pathOfImageVersionPhotos . $imageName, 100);

            // Set the original DPI to the saved image
            $imagickImage = new \Imagick($pathOfImageVersionPhotos . $imageName);
            $imagickImage->setImageResolution($originalDpi, $originalDpi);
            $imagickImage->writeImage($pathOfImageVersionPhotos . $imageName);
            $imagickImage->destroy();



            //thumbnail
            $imgFileCollection4             = Image::make($image->getRealPath());
            $imgFileCollection4             = $manager->make($image->getRealPath());
            $widthThumbnail                 = 150;
            $heightThumbnail                = 93;
            $imgFileCollection4->resize($widthThumbnail, $height_smallthumbnail, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $Versionthumbnail               =  'nzphotos-' . $request->color_create_version . $photo_id. $versionCounter.'-'
            .$imgFileCollection4->width()
            .'x'
            .$imgFileCollection4->height()
            .'.jpg';
            $pathOfImagethumbnail            = public_path() . '/images/version_photos/thumbnail/';
            $imgFileCollection4->save($pathOfImagethumbnail . $Versionthumbnail, 100);

             // Set the original DPI to the saved image
             $imagickImage = new \Imagick($pathOfImagethumbnail . $Versionthumbnail);
             $imagickImage->setImageResolution($originalDpi, $originalDpi);
             $imagickImage->writeImage($pathOfImagethumbnail . $Versionthumbnail);
             $imagickImage->destroy();

            //ends here


            // original image
            $imgFileCollection5             = Image::make($image->getRealPath());
            $imgFileCollection5             = $manager->make($image->getRealPath());
            $imageNameOriginal              =  'nzphotos-' . $request->color_create_version . $photo_id . $versionCounter . '-original.jpg';
            $pathOfImageoriginal            = public_path() . '/images/version_photos/originalImage/';
            $imgFileCollection5->save($pathOfImageoriginal . $imageNameOriginal, 100);

             // Set the original DPI to the saved image
             $imagickImage = new \Imagick($pathOfImageoriginal . $imageNameOriginal);
             $imagickImage->setImageResolution($originalDpi, $originalDpi);
             $imagickImage->writeImage($pathOfImageoriginal . $imageNameOriginal);
             $imagickImage->destroy();

            // ends here

            //single image start here
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

            $resizedWidth_SingleImage = $SingleImage->width();
            $resizedHeight_SingleImage = $SingleImage->height();

              //
              $imageNameCIDCOUNTER           = 'nzphotos-'.$photo_version->color_create_version.$photo_id.$photo_version->counter.'-'.$resizedWidth_SingleImage.'x'.$resizedHeight_SingleImage.'.jpg';
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


        $photo_version->singleImage          =   $imageNameCIDCOUNTER;
        $photo_version->image                =   $imageName;
        $photo_version->small_thumbnail      =   $Versionthumbnail;
        $photo_version->original_image       =   $imageNameOriginal;
        $photo_version->status               =   'on';
        // $photo_version->description          =   $photo->description;
        $photo_version->photo_id             =   $photo_id;
        // $photo_version->EK_price             =   $photo->EK_price;
        // $photo_version->EK_year              =   $photo->EK_year;
        // $photo_version->image_year           =   $photo->image_year;
        // $photo_version->photographer         =   $photo->photographer;
        // $photo_version->OF_height            =   $photo->OF_height;
        // $photo_version->OF_width             =   $photo->OF_width;
        // $photo_version->weather              =   $photo->weather;
        // $photo_version->season               =   $photo->season;
        // $photo_version->type                 =   $photo->type;
        $photo_version->original_filename    =   $original_filename;
        $photo_version->category_id          =   $photo->category_id;
        $photo_version->sub_category_id      =   $photo->sub_category_id;
        // $photo_version->title                =   $photo->title;
        $photo_version->color_create_version =   $photo->color_create_version;

        //


        $photo_version->save();

        $category = rawurlencode($request->input('category'));
        $subcategory = rawurlencode($request->input('subcategory'));

        return redirect()->to(route('admin.photos').'?category='.$category.'&subcategory='.$subcategory)
            ->with('success', 'Foto wurde erfolgreich hinzugefügt');



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
    public function edit(Request $request, $category_name, $photo_id, $subCatID = null)
    {
        $categories = DB::table('categories')->where('name', $category_name)->first();
        $category_id = $categories->id;
        $category_name = $categories->name;
        // dd($category_name);
        $photo = Photo::findOrfail($photo_id);
        // dd($photo->counter);
        $sub_categories = SubCategory::with('category')
        ->where('category_id',$category_id)
        ->get();

        $subCategoryName = SubCategory::where('id', $photo->sub_category_id)->value('name');
        // dd($sub_category->name);

        if($request->has('sort') && $request->has('order')) {
            $sort = $request->sort;
            $order = $request->order;

            $color_version_photos = DB::table('version_photos')
            ->select('version_photos.*')
            ->where([
                'version_photos.photo_id' => $photo_id,
                'version_photos.color_create_version' => 'C',
                ])
            ->orderBy($sort, $order)
            ->get();
        } else {
            $color_version_photos = DB::table('version_photos')
        ->select('version_photos.*')
        ->where([
            'version_photos.photo_id' => $photo_id,
            'version_photos.color_create_version' => 'C',
            ])
        ->orderBy('version_photos.created_at', 'desc')
        ->get();
        }


        //count the number of $color_version_photos
        $numberOfColor = count($color_version_photos);


        if($request->has('sort') && $request->has('order')) {
            $sort = $request->sort;
            $order = $request->order;

            $black_white_version_photos = DB::table('version_photos')
            ->select('version_photos.*')
            ->where([
                'version_photos.photo_id' => $photo_id,
                'version_photos.color_create_version' => 'B',
                ])
            ->orderBy($sort, $order)
            ->get();
        } else {
            $black_white_version_photos = DB::table('version_photos')
        ->select('version_photos.*')
        ->where([
            'version_photos.photo_id' => $photo_id,
            'version_photos.color_create_version' => 'B',
            ])
        ->orderBy('version_photos.created_at', 'desc')
        ->get();
        }




        //count the number of $black_white_version_photos
        $numberOfBlackAndWhite = count($black_white_version_photos);
        // dd($count);

        if($request->has('sort') && $request->has('order')) {
            $sort = $request->sort;
            $order = $request->order;

            $sepia_version_photos = DB::table('version_photos')
            ->select('version_photos.*')
            ->where([
                'version_photos.photo_id' => $photo_id,
                'version_photos.color_create_version' => 'S',
                ])
            ->orderBy($sort, $order)
            ->get();
        } else {
            $sepia_version_photos = DB::table('version_photos')
            ->select('version_photos.*')
            ->where([
                'version_photos.photo_id' => $photo_id,
                'version_photos.color_create_version' => 'S',
                ])
            ->orderBy('version_photos.created_at', 'desc')
            ->get();
        }



        //count the number of $sepia_version_photos
        $numberOfSepia = count($sepia_version_photos);

        $all_categories = Category::orderBy('sort', 'asc')->get();

        $color_version_category_id_1 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'C')
        ->where('status', 'on')
        ->value('category_id');
        $color_version_category1_name = Category::where('id', $color_version_category_id_1)->value('name');

        $all_sub_categories_1 = SubCategory::where('category_id', $color_version_category_id_1)->get();


        $color_version_sub_category_id_1 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'C')
        ->where('status', 'on')
        ->value('sub_category_id');
        $color_version_sub_category1_name = SubCategory::where('id', $color_version_sub_category_id_1)->value('name');


        $color_version_category_id_2 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'C')
        ->where('status', 'on')
        ->value('category_id_2');
        $color_version_category2_name = Category::where('id', $color_version_category_id_2)->value('name');


        $all_sub_categories_2 = SubCategory::where('category_id', $color_version_category_id_2)->get();

        $color_version_sub_category_id_2 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'C')
        ->where('status', 'on')
        ->value('sub_category_id_2');
        $color_version_sub_category2_name = SubCategory::where('id', $color_version_sub_category_id_2)->value('name');

        $color_version_category_id_3 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'C')
        ->where('status', 'on')
        ->value('category_id_3');
        $color_version_category3_name = Category::where('id', $color_version_category_id_3)->value('name');

        $all_sub_categories_3 = SubCategory::where('category_id', $color_version_category_id_3)->get();

        $color_version_sub_category_id_3 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'C')
        ->where('status', 'on')
        ->value('sub_category_id_3');
        $color_version_sub_category3_name = SubCategory::where('id', $color_version_sub_category_id_3)->value('name');

        //for black color

        $black_version_category_id_1 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'B')
        ->where('status', 'on')
        ->value('category_id');
        $black_version_category1_name = Category::where('id', $black_version_category_id_1)->value('name');

        $all_sub_categories_black_1 = SubCategory::where('category_id', $black_version_category_id_1)->get();

        $black_version_sub_category_id_1 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'B')
        ->where('status', 'on')
        ->value('sub_category_id');
        $black_version_sub_category1_name = SubCategory::where('id', $black_version_sub_category_id_1)->value('name');

        $black_version_category_id_2 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'B')
        ->where('status', 'on')
        ->value('category_id_2');
        $black_version_category2_name = Category::where('id', $black_version_category_id_2)->value('name');

        $all_sub_categories_black_2 = SubCategory::where('category_id', $black_version_category_id_2)->get();

        $black_version_sub_category_id_2 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'B')
        ->where('status', 'on')
        ->value('sub_category_id_2');

        $black_version_sub_category2_name = SubCategory::where('id', $black_version_sub_category_id_2)->value('name');

        $black_version_category_id_3 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'B')
        ->where('status', 'on')
        ->value('category_id_3');
        $black_version_category3_name = Category::where('id', $black_version_category_id_3)->value('name');

        $black_version_sub_category_id_3 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'B')
        ->where('status', 'on')
        ->value('sub_category_id_3');
        $black_version_sub_category3_name = SubCategory::where('id', $black_version_sub_category_id_3)->value('name');

        $all_sub_categories_black_3 = SubCategory::where('category_id', $black_version_category_id_3)->get();

        // end of black color


        // sepia color

        $sepia_version_category_id_1 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'S')
        ->where('status', 'on')
        ->value('category_id');
        $sepia_version_category1_name = Category::where('id', $sepia_version_category_id_1)->value('name');

        $sepia_version_sub_category_id_1 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'S')
        ->where('status', 'on')
        ->value('sub_category_id');
        $sepia_version_sub_category1_name = SubCategory::where('id', $sepia_version_sub_category_id_1)->value('name');

        $all_sub_categories_sepai_1 = SubCategory::where('category_id', $sepia_version_category_id_1)->get();

        $sepia_version_category_id_2 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'S')
        ->where('status', 'on')
        ->value('category_id_2');
        $sepia_version_category2_name = Category::where('id', $sepia_version_category_id_2)->value('name');

        $sepia_version_sub_category_id_2 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'S')
        ->where('status', 'on')
        ->value('sub_category_id_2');
        $sepia_version_sub_category2_name = SubCategory::where('id', $sepia_version_sub_category_id_2)->value('name');

        $all_sub_categories_sepai_2 = SubCategory::where('category_id', $sepia_version_category_id_2)->get();

        $sepia_version_category_id_3 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'S')
        ->where('status', 'on')
        ->value('category_id_3');
        $sepia_version_category3_name = Category::where('id', $sepia_version_category_id_3)->value('name');

        $sepia_version_sub_category_id_3 = VersionPhoto::where('photo_id', $photo_id)
        ->where('color_create_version', 'S')
        ->where('status', 'on')
        ->value('sub_category_id_3');
        $sepia_version_sub_category3_name = SubCategory::where('id', $sepia_version_sub_category_id_3)->value('name');

        $all_sub_categories_sepai_3 = SubCategory::where('category_id', $sepia_version_category_id_3)->get();

        // end of sepia color


        return view('admin.photos.edit', compact('photo', 'sub_categories' ,'category_id',
        'all_sub_categories_1', 'all_sub_categories_2', 'all_sub_categories_3',
        'all_sub_categories_black_1', 'all_sub_categories_black_2', 'all_sub_categories_black_3',
        'all_sub_categories_sepai_1', 'all_sub_categories_sepai_2', 'all_sub_categories_sepai_3',
        'category_name','numberOfColor',  'numberOfSepia', 'all_categories',
         'black_white_version_photos','numberOfBlackAndWhite',
        'subCategoryName','color_version_photos', 'sepia_version_photos',

        'color_version_category1_name', 'color_version_sub_category1_name',
        'color_version_category2_name', 'color_version_sub_category2_name',
        'color_version_category3_name', 'color_version_sub_category3_name',

        'black_version_category1_name', 'black_version_sub_category1_name',
        'black_version_category2_name', 'black_version_sub_category2_name',
        'black_version_category3_name', 'black_version_sub_category3_name',

        'sepia_version_category1_name', 'sepia_version_sub_category1_name',
        'sepia_version_category2_name', 'sepia_version_sub_category2_name',
        'sepia_version_category3_name', 'sepia_version_sub_category3_name',
        'subCatID'
        ));
    }

    public function version_sort($column, $order, $category_name, $photo_id, $color)
    {
        $color_version_photos = DB::table('version_photos')
        ->select('version_photos.*')
        ->where([
            'version_photos.photo_id' => $photo_id,
            'version_photos.color_create_version' => $color,
            ])
        ->orderBy($column, $order)
        ->get();

        return true;
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
        $photo                  = Photo::find($request->id);
        $photo->description     = $request->description;
        $photo->title           = $request->title;
        $photo->EK_price        = $request->EK_price;
        $photo->EK_year         = $request->EK_year;
        $photo->image_year      = $request->image_year;
        $photo->photographer    = $request->photographer;
        $photo->OF_height       = $request->OF_height;
        $photo->OF_width        = $request->OF_width;
        $photo->weather         = $request->weather;
        $photo->season          = $request->season;
        $photo->type            = $request->type;


        if($request->category_id && $request->sub_category_id)
        {
            $photo->category_id     = $request->category_id;
            $photo->sub_category_id = $request->sub_category_id;
        }

        if($request->input('status') == 'on')
        {
            $photo->status = 'on';
        }

        if($request->hasfile('image') && $request->image != '')
        {
            $image_path           = public_path() . '/images/photos/' . $photo->image;
            //image path for small thumbnail
            $small_thumbnail_path = public_path() . '/images/photos/thumbnail/' . $photo->small_thumbnail;
            //image path for original image
            $original_image_path  = public_path() . '/images/photos/originalImage/' . $photo->original_image;
            //image path for single image
            $watermark_image_path = public_path() . '/images/photos/singleImage/' . $photo->singleImage;
            //image path for original resized image
            $original_resized_image_path = public_path() . '/images/photos/OriginalResized/' . $photo->originalResized;
            //if file exists delete multiple images
            if(File::exists($image_path) && File::exists($small_thumbnail_path)
                && File::exists($original_image_path)
                && File::exists($watermark_image_path)
                && File::exists($original_resized_image_path)
                ) {
                File::delete($image_path);
                File::delete($small_thumbnail_path);
                File::delete($original_image_path);
                File::delete($watermark_image_path);
                File::delete($original_resized_image_path);
            }

            $image                  = $request->file('image');
            $ImageNameCollection    = time().$image->getClientOriginalName();
            $imgFileCollection      = Image::make($image->getRealPath()); //image resize from here;
            $imgFileCollection->resize(600, 340, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $height = $imgFileCollection->height();
            $width = $imgFileCollection->width();
            $pathCollection         = public_path() . '/images/photos/';
            $imgFileCollection->save($pathCollection . $ImageNameCollection);


           //upload file for small thmbnails
           $image                  = $request->file('image');

           //filename to store
           $imageName = time().$image->getClientOriginalName();
           //resize image in storage
           $smallthumbnailpath      = public_path() . '/images/photos/thumbnail/';
           $smallthumbnail          = Image::make($image->getRealPath());
            $smallthumbnail->resize(150, 93, function($constraint)
            {
                $constraint->aspectRatio();

            });
           $smallthumbnail->save($smallthumbnailpath . $imageName);

           //upload file without watermark and original image
           $filenamewithextension = $image->getClientOriginalName();
           $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
           $extension = $image->getClientOriginalExtension();
           $ImageNameOriginal       = $filename.'_'.time().'.'.$extension;
           $imgFileOriginal         = Image::make($image->getRealPath());       //image resize from here;
           $pathOfCollectionImage   = public_path() . '/images/photos/originalImage/';
           $image->save($pathOfCollectionImage . $ImageNameOriginal);


            //upload file with watermark and resized image with new variable single image
            $ImageNameWatermark= time().$image->getClientOriginalName();
            $SingleImage = Image::make($image->getRealPath())
            ->resize(900, 500, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $pathOfWatermarkImage   = public_path() . '/images/photos/singleImage/';
            $watermarkPath          = public_path('frontend/img/logo.png');
            $watermark              = Image::make($watermarkPath)->resize(160, 30)->opacity(40);
            $wmarkWidth             = $watermark->width();
            $wmarkHeight            = $watermark->height();
            $imgHeight              = $SingleImage->height();
            $imgWidth               = $SingleImage->width();

            $x                      = 20;
            $xx                     = 40;
            $y                      = 20;

            while ($x < $imgWidth) {
                $y = 20;
                $xx = $x;
                $line = 1;
                while($y < $imgHeight) {
                    if($line%2 == 0) {
                        $xx = $x+150;
                    }
                    $SingleImage->insert($watermark, 'top-left', $xx, $y);
                    $y += $wmarkHeight+100;
                    $xx = $x;

                    $line += 1;
                }

                  $x += $wmarkWidth+150;

            }

            $SingleImage->save($pathOfWatermarkImage . $ImageNameWatermark, 80); //for single image


            //



            //upload file without watermark and resized image edit images
            $WithoutWatermarkResized= time().$image->getClientOriginalName();
            $imgWithoutWatermarkResized = Image::make($image->getRealPath());
            $imgWithoutWatermarkResized->resize(600, 340, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $pathOfEditOriginalImage = public_path() . '/images/photos/originalResized/';
            $imgWithoutWatermarkResized->save($pathOfEditOriginalImage . $WithoutWatermarkResized); //for edit show images


            $photo->image           =    $ImageNameCollection;
            //update small_thumbnail image name in database
            $photo->small_thumbnail =    $imageName;
            //update original_image name in database
            $photo->original_image  =    $ImageNameOriginal;
            //update singleImage name in database
            $photo->singleImage     =    $ImageNameWatermark;
            //update originalResized name in database
            $photo->originalResized =    $WithoutWatermarkResized;

        } else {
            $ImageNameCollection  = $photo->image;
            $imageName = $photo->small_thumbnail;
            $ImageNameOriginal    = $photo->original_image;
            $ImageNameWatermark   = $photo->singleImage;
            $WithoutWatermarkResized = $photo->originalResized;
        }

        $category_name = $photo->category->name;
        $photo->update();
        $version_photo = VersionPhoto::where('photo_id', $photo->id);
        $version_photo->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return Redirect::to('admin/edit/photos/'. $category_name . '/' . $photo->id . '#allgemein');


        // return redirect()->route('admin.photos', [$category_name])
        // ->with('success', 'Foto wurde erfolgreich aktualisiert');
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

    public function updateTitle(Request $request)
    {
        $photo = Photo::find($request->photo_id);
        $photo->title = $request->title;
        $photo->save();

        $versionPhoto = VersionPhoto::where('photo_id', $request->photo_id)->
            update([
                'title' => $request->title
            ]);
        $versionPhoto->save();

        return response()->json([
            'title' => $photo->title
        ]);
    }
}
