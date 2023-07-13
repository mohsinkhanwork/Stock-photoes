@extends('layouts.admin')

@section('content')


<style>
    input{
  {{--  display: none;  --}}
  {{--  display: none;  --}}
}

label{
    cursor: pointer;
}

#imageName1{
        color: black;
      }


.version_status {
    {{--  display: none;  --}}
}


.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
    color: black;
    text-decoration: underline #8daf62 solid 3px;
    background: white;
    text-decoration-skip-ink: none;
    text-underline-offset: 8px;

}

input[type=checkbox] {
        accent-color: #428bca;
      }
</style>

<style>
    .sort-arrow {
        display: inline-block;
        margin-left: 5px;
        margin-right: 5px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 5px 4px 0 4px;
        border-color: #666 transparent transparent transparent;
      }

      .sort-arrow-up {
        border-width: 0px 6px 7px 6px;
        border-color: transparent transparent #666 transparent;
      }

      .sort-arrow-down {
        border-width: 7px 6px 0 6px;
        border-color: #666 transparent transparent transparent;
      }

</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Hoppla!</strong> Es gab einige Probleme mit Ihrer Eingabe.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Fotoverwaltung Detail </h3>
                </div>

    <form method="POST" action="{{ route('admin.update.photos') }}" enctype="multipart/form-data">
    @csrf
    {{--  <input type="hidden" name="category_id" value="{{ $category_id }}">  --}}
    <input type="hidden" name="id" value="{{ $photo->id }}">

    <div>
        <span class="version_status">

        </span>
    </div>
    <div class="card-body">

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label style="width: 20%;"> Aktiv? <code>*</code></label>
            <div style="width: 30%;">
                <input type="checkbox" style="display: block;" name="status" @if($photo->status == 'on') checked @endif>
            </div>
        </div>  --}}

         <div class="form-group" style="width: 100%;display: flex;margin-bottom: 6px;">
            <label style="width: 11%;"> Foto-ID </label>
            <div style="width: 30%; cursor: context-menu;">
                <span>
                    {{ $photo->id }}
                </span>
            </div>
        </div>
        <div class="form-group" style="width: 100%;display: flex;    margin-bottom: 10px;">
            <label style="width: 11%;"> Titel </label>
            <div style="width: 30%; ">
                <input type="text" class="form-control" name="title" value="{{ $photo->title }}"
                id="titleInput"
                >
            </div>
        </div>

        {{--  <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Beschreibung <code>*</code></label>
                <div style="width: 30%;">
                    <input type="text" required class="form-control" name="description" autofocus
                    @if(old('description'))
                       value="{{old('description')}}"
                       @elseif(isset($photo->description))
                       value="{{$photo->description}}"
                       @endif>

                </div>
        </div>  --}}

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="category_id" class="col-form-label" style="width: 20%;"> Unterkategorie zuweisen <code>*</code></label>
            <div style="width: 30%;">

                <select class="form-control" name="sub_category_id">
                    <option value="">Bitte w&#228;hlen</option>
                    @foreach ($sub_categories as $subcategory)
                    <option value="{{ $subcategory->id }}" @if($photo->sub_category_id == $subcategory->id) selected @endif>{{ $subcategory->name }}</option>
                    @endforeach
                </select>

            </div>
        </div>  --}}

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> Bild <code>*</code></label>
            <div style="width: 30%;">

                <img src=" {{ asset('/images/photos/originalResized/'.$photo->originalResized) }} "
                style="object-fit: cover;width: 32.255rem;border: 1px solid lightgrey;">

            </div>
        </div>  --}}

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> hochgeladenes Datum <code>*</code></label>
            <div style="width: 30%;">

                <p style="font-weight: bold;">
                    {{ $photo->created_at }}
                </p>

            </div>
        </div>  --}}




        <style>
            .nav-link.active {
                font-weight: bold;
            }

            .nav-link:not(.active) {
                font-weight: normal;
                color: black
            }
        </style>

        <ul class="nav nav-tabs" role="tablist" style="border: 0px;    font-size: 17px;">
            <li role="presentation" class="nav-item">
                <a href="#versionen" aria-controls="versionen" role="tab" data-toggle="tab" class="nav-link active" style="border: 0;padding-left: 0;">
                    Versionen
                </a>
            </li>
            <span style="
                font-size: 16px;
                font-weight: 600;
                margin-top: 9px;
            ">
                &#124;
            </span>
            <li role="presentation" class="nav-item">
                <a href="#allgemein" aria-controls="allgemein" role="tab" data-toggle="tab" class="nav-link" style="border: 0;">
                    Allgemein
                </a>
            </li>
        </ul>



        <! tab content -->
        <div class="tab-content mt-3" id="nav-tabContent" style="margin-top: 6px !important;">

            <div role="tabpanel" class="tab-pane fade show active" id="versionen">
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="nav-item">
                        <a href="#Farbe" aria-controls="Farbe" role="tab" data-toggle="tab" class="nav-link active" style="padding: 9px 9px 8px 0px">
                            Farbe &#40; {{ $numberOfColor }} &#41;

                        </a>
                    </li>
                    <span style="
            font-size: 14px;
            font-weight: 600;
            margin-top: 9px;
        ">
                &#124;
            </span>
                    <li role="presentation" class="nav-item">
                        <a href="#color" aria-controls="color" role="tab" data-toggle="tab" class="nav-link">
                        Schwarz/Weiß &#40; {{ $numberOfBlackAndWhite }} &#41;
                        </a>
                    </li>
                    <span style="
            font-size: 14px;
            font-weight: 600;
            margin-top: 9px;
        ">
                &#124;
            </span>
                    <li role="presentation" class="nav-item">
                        <a href="#Sepia" aria-controls="Sepia" role="tab" data-toggle="tab" class="nav-link">
                            Sepia &#40; {{ $numberOfSepia }} &#41;
                        </a>
                    </li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content mt-3" id="nav-tabContent" style="">

                    <div role="tabpanel" class="tab-pane fade show active" id="Farbe">

                        <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 1 </label>
                            <div style="display: flex; width: 44.5%;">
                                <select id="all_categories_color_cat_1" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @foreach ($all_categories as $category)
                                        <option value="{{ $category->name }}" {{ $category->name == $color_version_category1_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                </select> &nbsp; &nbsp;

                                <select id="all_subcategories_color_sub_cat_1" class="form-control">
                                    @foreach ($all_sub_categories_1 as $subcategory_1)
                                    <option value="{{ $subcategory_1->id }}" {{ $subcategory_1->name == $color_version_sub_category1_name ? 'selected' : '' }}>{{ $subcategory_1->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 2 </label>
                            <div style="display: flex; width: 44.5%;">
                                <select id="all_categories_color_cat_2" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @foreach ($all_categories as $category)
                                        <option value="{{ $category->name }}" {{ $category->name == $color_version_category2_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                </select> &nbsp; &nbsp;

                                <select id="all_subcategories_color_sub_cat_2" class="form-control">

                                    @foreach ($all_sub_categories_2 as $subcategory_2)
                                    <option value="{{ $subcategory_2->id }}" {{ $subcategory_2->name == $color_version_sub_category2_name ? 'selected' : '' }}>{{ $subcategory_2->name }}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>
                        <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 3 </label>
                            <div style="display: flex; width: 44.5%;">
                                <select id="all_categories_color_cat_3" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @foreach ($all_categories as $category)
                                        <option value="{{ $category->name }}" {{ $category->name == $color_version_category3_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                </select> &nbsp; &nbsp;

                                <select id="all_subcategories_color_sub_cat_3" class="form-control">

                                    @foreach ($all_sub_categories_3 as $subcategory_3)
                                    <option value="{{ $subcategory_3->id }}" {{ $subcategory_3->name == $color_version_sub_category3_name ? 'selected' : '' }}>{{ $subcategory_3->name }}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>

                     <div style="width: 100%;text-align: right;">
                        <a href="{{ route('admin.create.versions', ['photo_id' => $photo->id, 'counter' => $photo->counter, 'color_create_version' => 'C',
                            'category_name' => $category_name ,
                            ]) }}"
                            id="create_version_button_C"
                            class="btn btn-primary btn-sm" style="margin-top: -102px;">
                             Neue Version
                        </a>
                        </div>

                     <div style="width: 100%;display: flex;margin-top: -36px">
                     <table class="table table-striped table-bordered data_table_yajra" style="width:100%;    font-size: 13px !important;">
                    <thead>
                        <tr>
                            <th style="text-align: right !important; padding-right: 6px; width:12px;">#</th>
                            <th style="text-align: right !important; padding-right: 9px; width:24px;">
                                <div style="display: inline-block; text-align: left;">
                                    Version
                                  </div>
                                  <div style="display: inline-block;">
                                    <a href="{{ url()->current().'?sort=counter&order=asc' }}" style="display: block; margin-bottom: -9px;">
                                      <i class="sort-arrow sort-arrow-up" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ url()->current().'?sort=counter&order=desc' }}" style="display: block;">
                                      <i class="sort-arrow sort-arrow-down" aria-hidden="true"></i>
                                    </a>
                                  </div>
                              </th>

                            <th style="width: 31px;text-align: center;">Foto</th>
                            <th style="width:40px;">Hinzugefügt</th>
                            <th style="width:224px;">Original Dateiname</th>
                            <th style="width:15px;">Aktiv?</th>
                            <th style="width:15px;">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($color_version_photos as $key => $color_version_photo)
                        <tr>
                            <td style="text-align: right !important; padding-right: 6px;">{{ ++$key }}</td>
                            <td style="text-align: right !important; padding-right: 13px;">{{ $color_version_photo->counter }}</td>
                            <td style="text-align: center;">
                                <img src="{{ asset('/images/version_photos/thumbnail/'.$color_version_photo->small_thumbnail) }}"
                                style="max-height: 50px; max-width: 100%; margin-top:5px; margin-bottom:3px;">
                            </td>
                            <td>{{ $color_version_photo->created_at }}</td>
                            <td>
                                {{ $color_version_photo->original_filename }}
                            </td>
                            <td>

                                <input type="radio" name="status_C" value="{{ $color_version_photo->id }}" {{ $color_version_photo->status == 'on' ? 'checked' : '' }}
                                style="display: block;margin-left: 22px;">

                            </td>
                            <td>
                                <a href="{{ route('admin.edit.versions', ['version_id' => $color_version_photo->id]) }}" style="color: black">
                                    <i class="fa fa-edit"> </i>
                                </a>

                                <a href="javascript:void(0)" onclick="deleteVersionPhoto({{ $color_version_photo->id }})" style="color: black">
                                    <i class="fa fa-trash"> </i>
                                </a>

                                {{--  <a href="{{ route('admin.delete.version', ['id' => $color_version_photo->id, 'photo_id' => $photo->id, 'category_name' => $category_name, 'color' => $color_version_photo->color]) }}" style="color: black">
                                    <i class="fa fa-trash"> </i>
                                </a>  --}}

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <div class="card-footer" style="text-align: right;padding-right: 0;">
                    <a href="{{ url('admin/photos') }}?category={{ urlencode($category_name) }}&subcategory={{ urlencode($subCatID) }}"
                    class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
                        Abbrechen
                    </a>

                    <button type="button" class="btn btn-primary btn-sm"
                    style="margin-left: 2px;"
                    id="btn-save">
                    Speichern
                    </button>


                    </div>

                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="color">
                        <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 1 </label>
                            <div style="display: flex; width: 44.5%;">
                                <select id="all_categories_black_cat_1" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @foreach ($all_categories as $category)
                                        <option value="{{ $category->name }}" {{ $category->name == $black_version_category1_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                </select> &nbsp; &nbsp;

                                <select id="all_subcategories_black_sub_cat_1" class="form-control">

                                    @foreach ($all_sub_categories_black_1 as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $subcategory->name == $black_version_sub_category1_name ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                    @endforeach

                                </select>

                            </div>
                         </div>
                         <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 2 </label>

                                <div style="display: flex; width: 44.5%;">
                                    <select id="all_categories_black_cat_2" class="form-control">
                                        <option value="">Kategorie auswählen</option>
                                            @foreach ($all_categories as $category)
                                            <option value="{{ $category->name }}" {{ $category->name == $black_version_category2_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                    </select> &nbsp; &nbsp;

                                    <select id="all_subcategories_black_sub_cat_2" class="form-control">

                                        @foreach ($all_sub_categories_black_2 as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ $subcategory->name == $black_version_sub_category2_name ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                         <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 3 </label>
                            <div style="display: flex; width: 44.5%;">
                                <select id="all_categories_black_cat_3" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @foreach ($all_categories as $category)
                                        <option value="{{ $category->name }}" {{ $category->name == $black_version_category3_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                </select> &nbsp; &nbsp;

                                <select id="all_subcategories_black_sub_cat_3" class="form-control">


                                    @foreach ($all_sub_categories_black_3 as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $subcategory->name == $black_version_sub_category3_name ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                         </div>
                         <div style="width: 100%;text-align: right;">
                            <a href="{{ route('admin.create.versions', ['photo_id' => $photo->id, 'counter' => $photo->counter, 'color_create_version' => 'B',
                                'category_name' => urlencode($category_name) ,
                                ]) }}"
                                id="create_version_button_B"
                                class="btn btn-primary btn-sm" style="margin-top: -102px;"> Neue Version
                            </a>

                            {{--  <a href="#" onclick="selectTabAndReload(event, 'B')" class="btn btn-primary btn-sm" style="margin-top: -102px;">
                                Neue Version
                            </a>  --}}



                            </div>

                         <div style="width: 100%;display: flex;margin-top: -36px">
                         <table class="table table-striped table-bordered data_table_yajra" style="width:100%;    font-size: 13px !important;">
                        <thead>
                            <tr>
                                <th style="text-align: right !important; padding-right: 6px; width:12px;">#</th>
                                <th style="text-align: right !important; padding-right: 9px; width:24px;">
                                    <div style="display: inline-block; text-align: left;">
                                        Version
                                      </div>
                                      <div style="display: inline-block;">
                                        <a href="{{ url()->current().'?sort=counter&order=asc' }}" style="display: block; margin-bottom: -9px;">
                                          <i class="sort-arrow sort-arrow-up" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ url()->current().'?sort=counter&order=desc' }}" style="display: block;">
                                          <i class="sort-arrow sort-arrow-down" aria-hidden="true"></i>
                                        </a>
                                      </div>
                                  </th>
                                <th style="width: 31px;text-align: center;">Foto</th>
                                <th style="width:40px;">Hinzugefügt</th>
                                <th style="width:224px;">Original Dateiname</th>
                                <th style="width:15px;">Aktiv?</th>
                                <th style="width:15px">Aktion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($black_white_version_photos as $key => $black_white_version_photo)
                            <tr>
                                <td style="text-align: right !important; padding-right: 6px;">{{ ++$key }}</td>
                                <td style="text-align: right !important; padding-right: 13px;">{{ $black_white_version_photo->counter }}</td>
                                <td style="text-align: center;">
                                <img src="{{ asset('/images/version_photos/thumbnail/'.$black_white_version_photo->small_thumbnail) }}" style="max-height: 50px; max-width: 100%; margin-top:5px; margin-bottom:3px;">
                                </td>
                                <td>{{ $black_white_version_photo->created_at }}</td>
                                <td>
                                    {{ $black_white_version_photo->original_filename }}
                                <td>


                                <input type="radio" name="status_B" value="{{ $black_white_version_photo->id }}" {{ $black_white_version_photo->status == 'on' ? 'checked' : '' }}
                                style="display: block;margin-left: 22px;">

                                </td>
                                <td>
                                    <a href="{{ route('admin.edit.versions', ['version_id' => $black_white_version_photo->id]) }}" style="color: black">
                                        <i class="fa fa-edit"> </i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="deleteVersionPhoto({{ $black_white_version_photo->id }})" style="color: black">
                                        <i class="fa fa-trash"> </i>
                                    </a>
                                    {{--  <a href="{{ route('admin.delete.version', ['id' => $black_white_version_photo->id, 'photo_id' => $photo->id, 'category_name' => $category_name , 'color' => $black_white_version_photo->color]) }}" style="color: black">
                                        <i class="fa fa-trash"> </i>
                                    </a>  --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>

                    <div class="card-footer" style="text-align: right;padding-right: 0px;">
                        <a href="{{ url('admin/photos') }}?category={{ urlencode($category_name) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
                            Abbrechen
                        </a>

                        <button type="button" class="btn btn-primary btn-sm"
                        style="margin-left: 2px;"
                        id="btn-save-black">
                        Speichern
                        </button>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="Sepia">
                        <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 1 </label>
                            <div style="display: flex; width: 44.5%;">
                                <select id="all_categories_sepia_cat_1" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @foreach ($all_categories as $category)
                                        <option value="{{ $category->name }}" {{ $category->name == $sepia_version_category1_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                </select> &nbsp; &nbsp;

                                <select id="all_subcategories_sepia_sub_cat_1" class="form-control">

                                    @foreach ($all_sub_categories_sepai_1  as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $subcategory->name == $sepia_version_sub_category1_name ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                    @endforeach

                                </select>

                            </div>
                         </div>
                         <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 2 </label>

                            <div style="display: flex; width: 44.5%;">
                                <select id="all_categories_sepia_cat_2" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @foreach ($all_categories as $category)
                                        <option value="{{ $category->name }}" {{ $category->name == $sepia_version_category2_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                </select> &nbsp; &nbsp;

                                <select id="all_subcategories_sepia_sub_cat_2" class="form-control">

                                    @foreach ($all_sub_categories_sepai_2  as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $subcategory->name == $sepia_version_sub_category2_name ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                         </div>
                         <div class="form-group" style="width: 100%;display: flex;">
                            <label for="name" class="col-form-label" style="width: 8%;"> Kategorie 3 </label>

                            <div style="display: flex; width: 44.5%;">
                                <select id="all_categories_sepia_cat_3" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @foreach ($all_categories as $category)
                                        <option value="{{ $category->name }}" {{ $category->name == $sepia_version_category3_name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                </select> &nbsp; &nbsp;

                                <select id="all_subcategories_sepia_sub_cat_3" class="form-control">

                                    @foreach ($all_sub_categories_sepai_3  as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $subcategory->name == $sepia_version_sub_category3_name ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                         </div>

                         <div style="width: 100%;text-align: right;">
                            <a href="{{ route('admin.create.versions', ['photo_id' => $photo->id, 'counter' => $photo->counter, 'color_create_version' => 'S',
                                'category_name' => $category_name ,
                                ]) }}"
                                id="create_version_button_S"
                                class="btn btn-primary btn-sm" style="margin-top: -102px;">
                                Neue Version </a>


                                {{--  <a href="#" onclick="selectTabAndReload(event, 'S')" class="btn btn-primary btn-sm" style="margin-top: -102px;">
                                    Neue Version
                                </a>  --}}

                            </div>

                         <div style="width: 100%;display: flex;margin-top: -36px">
                         <table class="table table-striped table-bordered data_table_yajra" style="width:100%;    font-size: 13px !important;">
                        <thead>
                            <tr>
                                <th style="text-align: right !important; padding-right: 6px; width:12px;">#</th>
                                <th style="text-align: right !important; padding-right: 9px; width:24px;">
                                    <div style="display: inline-block; text-align: left;">
                                        Version
                                      </div>
                                      <div style="display: inline-block;">
                                        <a href="{{ url()->current().'?sort=counter&order=asc' }}" style="display: block; margin-bottom: -9px;">
                                          <i class="sort-arrow sort-arrow-up" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ url()->current().'?sort=counter&order=desc' }}" style="display: block;">
                                          <i class="sort-arrow sort-arrow-down" aria-hidden="true"></i>
                                        </a>
                                      </div>
                                  </th>
                                <th style="width: 31px;text-align: center;">Foto</th>
                                <th style="width:40px;">Hinzugefügt</th>
                                <th style="width:224px;">Original Dateiname</th>
                                <th style="width:15px;">Aktiv?</th>
                                <th style="width:15px;">Aktion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sepia_version_photos as $key => $sepia_version_photo)
                            <tr>
                                <td style="text-align: right !important; padding-right: 6px;">{{ ++$key }}</td>
                                <td style="text-align: right !important; padding-right: 13px;">{{ $sepia_version_photo->counter }}</td>
                                <td style="text-align: center;">
                                    <img src="{{ asset('/images/version_photos/thumbnail/'.$sepia_version_photo->small_thumbnail) }}" style="max-height: 50px; max-width: 100%; margin-top:5px; margin-bottom:3px;">
                                </td>
                                <td>{{ $sepia_version_photo->created_at }}</td>
                                <td>{{ $sepia_version_photo->original_filename }}</td>
                                <td>

                                <input type="radio" name="status_S" value="{{ $sepia_version_photo->id }}" {{ $sepia_version_photo->status == 'on' ? 'checked' : '' }}
                                 style="display: block;margin-left: 22px;">
                                </td>
                                <td>
                                    <a href="{{ route('admin.edit.versions', ['version_id' => $sepia_version_photo->id]) }}" style="color: black">
                                        <i class="fa fa-edit"> </i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="deleteVersionPhoto({{ $sepia_version_photo->id }})" style="color: black">
                                        <i class="fa fa-trash"> </i>
                                    </a>
                                    {{--  <a href="{{ route('admin.delete.version', ['id' => $sepia_version_photo->id , 'photo_id' => $photo->id, 'category_name' => $category_name, 'color' => $sepia_version_photo->color]) }}" style="color: black">
                                        <i class="fa fa-trash"> </i>
                                    </a>  --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="card-footer" style="text-align: right;padding-right: 0;">
                        <a href="{{ url('admin/photos') }}?category={{ urlencode($category_name) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
                            Abbrechen
                        </a>

                        <button type="button" class="btn btn-primary btn-sm"
                        style="margin-left: 2px;"
                        id="btn-save-sepia">
                        Speichern
                        </button>
                        </div>
                    </div>

                </div>
            </div>



            <div role="tabpanel" class="tab-pane fade" id="allgemein">

                    <div class="form-group" style="width: 108%;display: flex;">
                        <div style="width: 54%; display: flex">
                            <label for="original_medium" class="col-form-label" style="width: 30%;"> Original-Medium </label>
                        <div style="width: 60%;">

                            <input type="radio" name="type" id="digitalphoto" value="Digitalfoto" @if ($photo->type == 'Digitalfoto') checked @endif style="display:inline-table">&nbsp;&nbsp;&nbsp;Digitalfoto
                        <div style="display: flex">
                        <input type="radio" id="select" name="type" value="@if ($photo->type != 'Digitalfoto'){{ $photo->type }}@endif"
                        @if ($photo->type != 'Digitalfoto') checked @endif onchange="updateRadio()" style="display: block;" >&nbsp;&nbsp;&nbsp;
                        <select class="form-control" id="select-options">
                            <option value="">Select</option>
                            <option value="Ambrotype" @if ($photo->type == 'Ambrotype') selected @endif>Ambrotype</option>
                            <option value="Tintype" @if ($photo->type == 'Tintype') selected @endif>Tintype</option>
                            <option value="Salt Print" @if ($photo->type == 'Salt Print') selected @endif>Salt Print</option>
                            <option value="Albumen" @if ($photo->type == 'Albumen') selected @endif>Albumen</option>
                            <option value="Gelatine Silver Print" @if ($photo->type == 'Gelatine Silver Print') selected @endif>Gelatine Silver Print</option>
                            <option value="Card de Visite (CDV)" @if ($photo->type == 'Card de Visite (CDV)') selected @endif>Card de Visite (CDV)</option>
                            <option value="Cabinet Card" @if ($photo->type == 'Cabinet Card') selected @endif>Cabinet Card</option>
                            <option value="Magic Lantern" @if ($photo->type == 'Magic Lantern') selected @endif>Magic Lantern</option>
                            <option value="Sketch B/W" @if ($photo->type == 'Sketch B/W') selected @endif>Sketch B/W</option>
                            <option value="Sketch Colour" @if ($photo->type == 'Sketch Colour') selected @endif>Sketch Colour</option>
                            <option value="Stereoview Daguerreotype" @if ($photo->type == 'Stereoview Daguerreotype') selected @endif>Stereoview Daguerreotype</option>
                            <option value="Stereoview Albumen" @if ($photo->type == 'Stereoview Albumen') selected @endif>Stereoview Albumen</option>
                            <option value="Postcard" @if ($photo->type == 'Postcard') selected @endif>Postcard</option>
                            <option value="Cigarette Cards" @if ($photo->type == 'Cigarette Cards') selected @endif>Cigarette Cards</option>
                        </select>
                        </div>

                        <script>
                            function updateRadio() {
                            var selectedValue = document.getElementById('select-options').value;
                            document.getElementById('select').value = selectedValue;
                            }

                            document.getElementById('select-options').addEventListener('change', updateRadio);
                        </script>


                            <br />

                            <div style="margin-left: 20px;">

                                <p>
                                    <span style="font-weight: bold;"> Original-Format </span>
                                        <label for="Hohe" style="margin-left: 20px;"> Höhe </label>
                                            <input type="text" name="OF_height" value="{{ $photo->OF_height }}" class="form-control" style="display:inline-table; width: 60px;"> cm

                                        <label for="Breite" style="margin-left: 20px;"> Breite </label>
                                            <input type="text" name="OF_width" value="{{ $photo->OF_width }}" class="form-control" style="display:inline-table;width: 60px;">  cm
                                </p>

                                <p>
                                    <label for="Ek-Preis" > EK-Preis </label>
                                        <input type="text" name="EK_price" value="{{ $photo->EK_price }}" class="form-control" style="display:inline-table;width: 60px;">

                                    <label for="EK-Jahr" style="margin-left: 20px;"> EK-Jahr </label>
                                        <input type="text" name="EK_year" value="{{ $photo->EK_year }}" class="form-control" style="display:inline-table; width: 60px;">
                                </p>
                            </div>


                        </div>
                        </div>
                        <div style="width: 54%">
                            <div>
                                <label for="weather" class="col-form-label"> SEO/Such-tags </label>
                            </div>

                            <div style="display: flex;">
                                <label for="weather" class="col-form-label" style="width: 24%;"> Wetter </label>
                                <select id="weather" class="form-control" name="weather" style="width: 59%;">
                                    <option value="">-- Select --</option>
                                    <option value="Sunny" {{ $photo->weather == 'Sunny' ? 'selected' : '' }}> Sunny </option>
                                    <option value="Sunset" {{ $photo->weather == 'Sunset' ? 'selected' : '' }}> sunset </option>
                                    <option value="Sunrise" {{ $photo->weather == 'Sunrise' ? 'selected' : '' }}> sunrise </option>
                                    <option value="Cloudy" {{ $photo->weather == 'Cloudy' ? 'selected' : '' }}> cloudy </option>
                                    <option value="Foggy" {{ $photo->weather == 'Foggy' ? 'selected' : '' }}> Foggy </option>
                                    <option value="Snow" {{ $photo->weather == 'Snow' ? 'selected' : '' }}> Snowy </option>
                                </select>

                            </div>
                            <br />
                            <div style="display: flex;">
                                <label for="season" class="col-form-label" style="width: 24%;"> Season </label>
                                <select id="season" class="form-control" name="season" style="width: 59%;">
                                    <option value="Summer" {{ $photo->season == 'Summer' ? 'selected' : '' }}> Summer </option>
                                    <option value="Autumn" {{ $photo->season == 'Autumn' ? 'selected' : '' }}> Autumn </option>
                                    <option value="Winter" {{ $photo->season == 'Winter' ? 'selected' : '' }}> Winter </option>
                                    <option value="Spring" {{ $photo->season == 'Spring' ? 'selected' : '' }}> Spring </option>
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="form-group" style="width: 100%;display: flex;">
                        <label for="name" class="col-form-label" style="width: 15%;"> Image-Jahr </label>
                        <div style="width: 8%;">
                            <input type="text" class="form-control" name="image_year" value="{{ $photo->image_year }}">
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;display: flex;">
                        <label for="photographer" class="col-form-label" style="width: 15%;"> Fotograf </label>
                        <div style="width: 29.5%;">

                            <input type="radio" name="photographer" value="Harald Hochmann" style="display:inline-table" onclick="document.getElementById('photographer-custom').disabled = true;"
                            @if ($photo->photographer == 'Harald Hochmann') checked @endif
                            >&nbsp;&nbsp;&nbsp; Harald Hochmann <br />
                            <input type="radio" name="photographer" value="Unbekannt (Public Domain)" style="display:inline-table" onclick="document.getElementById('photographer-custom').disabled = true;"
                            @if ($photo->photographer == 'Unbekannt (Public Domain)') checked @endif
                            >&nbsp;&nbsp;&nbsp; Unbekannt (Public Domain) <br />

                            <input type="radio" name="photographer" value="other" style="display:inline-table" onclick="document.getElementById('photographer-custom').disabled = false;"
                            @if ($photo->photographer != 'Harald Hochmann' && $photo->photographer != 'Unbekannt (Public Domain)' && $photo->photographer != null) checked @endif
                            >&nbsp;&nbsp;&nbsp;
                            <input type="text"  class="form-control" style="margin-top: 6px;display:inline-table;width: 55%;" id="photographer-custom" name="photographer" disabled> (Public Domain)


                        </div>
                    </div>


                    <div class="form-group" style="width: 100%;display: flex;">
                        <label for="description" class="col-form-label" style="width: 15%;"> Bescchreibung </label>
                        <div style="width: 86%;">
                            <textarea class="form-control" name="description" rows="3" >{{ $photo->description }}</textarea>
                        </div>
                    </div>


                    <div class="card-footer" style="text-align: right;padding-right: 0;">
                        <a href="{{ url('admin/photos') }}?category={{ $category_name }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
                            Abbrechen
                        </a>
                            <button type="submit" class="btn btn-primary btn-sm filterButton" style="font-size: 13px;"> Speichern </button>
                        </div>

            </div>


        </div>


        <style>
            input{
          display: none;
        }

        label{
            cursor: pointer;
        }

        #imageName1{
                color: black;
              }
        </style>


            </div>

</form>
        </div>

    </div>
</div>

<script>
    document.getElementById('create_version_button_C').addEventListener('click', function(e){
        e.preventDefault();

        var category = document.getElementById('all_categories_color_cat_1').value;
        var subcategory = document.getElementById('all_subcategories_color_sub_cat_1').value;
        var url = this.getAttribute('href');

        if (!category) {
            category = "{{ $category_name }}"; // assuming that this JavaScript is inlined in a Blade file
        }

        window.location.href = url + "?category=" + encodeURIComponent(category) + "&subcategory=" + encodeURIComponent(subcategory);
    });

    document.getElementById('create_version_button_B').addEventListener('click', function(e){
        e.preventDefault();

        var category = document.getElementById('all_categories_black_cat_1').value;
        var subcategory = document.getElementById('all_subcategories_black_sub_cat_1').value;
        var url = this.getAttribute('href');

        // If category is null or empty, use the defaultCategoryName value
        if (!category) {
            category = "{{ $category_name }}"; // assuming that this JavaScript is inlined in a Blade file
        }

        window.location.href = url + "?category=" + encodeURIComponent(category) + "&subcategory=" + encodeURIComponent(subcategory);
    });


    document.getElementById('create_version_button_S').addEventListener('click', function(e){
        e.preventDefault();

        var category = document.getElementById('all_categories_sepia_cat_1').value;
        var subcategory = document.getElementById('all_subcategories_sepia_sub_cat_1').value;
        var url = this.getAttribute('href');

        if (!category) {
            category = "{{ $category_name }}"; // assuming that this JavaScript is inlined in a Blade file
        }

        window.location.href = url + "?category=" + encodeURIComponent(category) + "&subcategory=" + encodeURIComponent(subcategory);
    });



    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $('#titleInput').blur(function() {
        var title = $(this).val();
        var photo_id = {{ $photo->id }};
        $.ajax({
            url: "{{ route('admin.update.versions.title') }}",
            type: "POST",
            data: {
                title: title,
                photo_id: photo_id,
                'token': '{{ csrf_token() }}',
            },
            success: function(response) {
                $('#titleInput').val(data.title);
            },
        })
    });


    $('#all_categories_color_cat_1').change(function() {
        //e.preventDefault();
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_color_sub_cat_1');

        if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');

            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories') }}",
                type: "POST",
                data: {
                    category_name_color_cat1: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_color_cat1: null, // Reset subcategory
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}
            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                }
                else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                    subcategoriesSelect.removeAttr('disabled');
                    $.each(subcategories, function(index, subcategory) {
                        subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                    });
                    // Select the first option
                    subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                    subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });

        {{--  $.ajax({
            url: "{{ route('admin.update.versions.categories') }}",
            type: "POST",
            data: {
                category_name_color_cat1: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}
    });
});

$('#btn-save').on('click',function(e){

    e.preventDefault();
    let selectOne=$('#all_categories_color_cat_1').val();
    let selectSecond=$('#all_subcategories_color_sub_cat_1').val();

    let request1 = $.ajax({
        url: "{{ route('admin.update.versions.categories') }}",
        type: "POST",
        data: {
            category_name_color_cat1: selectOne,
            photo_id: {{ $photo->id }},
            subcategory_id_color_cat1: selectSecond,
            _token: '{{ csrf_token() }}'
        }
    });


let selectThree=$('#all_categories_color_cat_2').val();
let selectFour=$('#all_subcategories_color_sub_cat_2').val();


let request2 = $.ajax({
    url: "{{ route('admin.update.versions.categories2') }}",
    type: "POST",
    data: {
        category_name_color_cat2: selectThree,
        photo_id: {{ $photo->id }},
        subcategory_id_color_cat2: selectFour,
        _token: '{{ csrf_token() }}'
    }
});


let selectFive=$('#all_categories_color_cat_3').val();
let selectSix=$('#all_subcategories_color_sub_cat_3').val();

let request3 = $.ajax({
    url: "{{ route('admin.update.versions.categories3') }}",
    type: "POST",
    data: {
        category_name_color_cat3: selectFive,
        photo_id: {{ $photo->id }},
        subcategory_id_color_cat3: selectSix,
        _token: '{{ csrf_token() }}'
    }
});

$.when(request1, request2, request3).done(function(response1, response2, response3){
    location.reload();
}).fail(function(xhr, status, error) {
    alert(xhr.responseText);
});

})

$('#btn-save-black').on('click',function(e){
    e.preventDefault();

    let selectSeven=$('#all_categories_black_cat_1').val();
    let selectEight=$('#all_subcategories_black_sub_cat_1').val();

    let request4 = $.ajax({
        url: "{{ route('admin.update.versions.categories4') }}",
        type: "POST",
        data: {
            category_name_black_cat1: selectSeven,
            photo_id: {{ $photo->id }},
            subcategory_id_black_cat1: selectEight,
            _token: '{{ csrf_token() }}'
        }
    });

    let selectNine=$('#all_categories_black_cat_2').val();
    let selectTen=$('#all_subcategories_black_sub_cat_2').val();

    let request5 = $.ajax({
        url: "{{ route('admin.update.versions.categories5') }}",
        type: "POST",
        data: {
            category_name_black_cat2: selectNine,
            photo_id: {{ $photo->id }},
            subcategory_id_black_cat2: selectTen,
            _token: '{{ csrf_token() }}'
        }
    });

    let selectEleven=$('#all_categories_black_cat_3').val();
    let selectTwelve=$('#all_subcategories_black_sub_cat_3').val();

    let request6 = $.ajax({
        url: "{{ route('admin.update.versions.categories6') }}",
        type: "POST",
        data: {
            category_name_black_cat3: selectEleven,
            photo_id: {{ $photo->id }},
            subcategory_id_black_cat3: selectTwelve,
            _token: '{{ csrf_token() }}'
        }
    });

    $.when(request4, request5, request6).done(function(response4, response5, response6){
        location.reload();
    }).fail(function(xhr, status, error) {
        alert(xhr.responseText);
    });

})

$('#btn-save-sepia').on('click',function(e){
    e.preventDefault();

    let selectThirteen = $('#all_categories_sepia_cat_1').val();
    let selectFourteen = $('#all_subcategories_sepia_sub_cat_1').val();

    let request7 = $.ajax({
        url: "{{ route('admin.update.versions.categories7') }}",
        type: "POST",
        data: {
            category_name_sepia_cat1: selectThirteen,
            photo_id: {{ $photo->id }},
            subcategory_id_sepia_cat1: selectFourteen,
            _token: '{{ csrf_token() }}'
        }
    });

    let selectFifteen = $('#all_categories_sepia_cat_2').val();
    let selectSixteen = $('#all_subcategories_sepia_sub_cat_2').val();

    let request8 = $.ajax({
        url: "{{ route('admin.update.versions.categories8') }}",
        type: "POST",
        data: {
            category_name_sepia_cat2: selectFifteen,
            photo_id: {{ $photo->id }},
            subcategory_id_sepia_cat2: selectSixteen,
            _token: '{{ csrf_token() }}'
        }
    });

    let selectSeventeen = $('#all_categories_sepia_cat_3').val();
    let selectEighteen = $('#all_subcategories_sepia_sub_cat_3').val();

    let request9 = $.ajax({
        url: "{{ route('admin.update.versions.categories9') }}",
        type: "POST",
        data: {
            category_name_sepia_cat3: selectSeventeen,
            photo_id: {{ $photo->id }},
            subcategory_id_sepia_cat3: selectEighteen,
            _token: '{{ csrf_token() }}'
        }
    });

    $.when(request7, request8, request9).done(function(response7, response8, response9){
        location.reload();
    }).fail(function(xhr, status, error) {
        alert(xhr.responseText);
    });

});

            // Trigger the change event if the category is pre-selected
            if($('#all_categories_color_cat_1').val() !== ''){
                $('#all_categories_color_cat_1').trigger('change');
            }


        {{--  $('#all_subcategories_color_sub_cat_1').change(function() {
            var category_name = $('#all_categories_color_cat_1').val();
            var subcategory_id = $(this).val();

            $.ajax({
                url: "{{ route('admin.update.versions.categories') }}",
                type: "POST",
                data: {
                    category_name_color_cat1: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_color_cat1: subcategory_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });  --}}


        $(document).ready(function() {
    $('#all_categories_color_cat_2').change(function() {
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_color_sub_cat_2');
        if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');
            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories2') }}",
                type: "POST",
                data: {
                    category_name_color_cat2: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_color_cat2: null, // Reset subcategory
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}
            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                } else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                        subcategoriesSelect.removeAttr('disabled');
                        $.each(subcategories, function(index, subcategory) {
                            subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                        });
                        // Select the first option
                        subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                        subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });

        {{--  $.ajax({
            url: "{{ route('admin.update.versions.categories2') }}",
            type: "POST",
            data: {
                category_name_color_cat2: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}

    });
});
     // Trigger the change event if the category is pre-selected
     if($('#all_categories_color_cat_2').val() !== ''){
        $('#all_categories_color_cat_2').trigger('change');
    }

      {{--  $('#all_subcategories_color_sub_cat_2').change(function() {
        var category_name = $('#all_categories_color_cat_2').val();
        var subcategory_id = $(this).val();

        $.ajax({
            url: "{{ route('admin.update.versions.categories2') }}",
            type: "POST",
            data: {
                category_name_color_cat2: category_name,
                photo_id: {{ $photo->id }},
                subcategory_id_color_cat2: subcategory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    });    --}}


    // Color Category 3
    $(document).ready(function() {
    $('#all_categories_color_cat_3').change(function() {
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_color_sub_cat_3');
         if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');
            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories3') }}",
                type: "POST",
                data: {
                    category_name_color_cat3: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_color_cat3: null, // Reset subcategory
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}
            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                } else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                        subcategoriesSelect.removeAttr('disabled');
                        $.each(subcategories, function(index, subcategory) {
                            subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                        });
                        // Select the first option
                        subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                        subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });

        {{--  $.ajax({
            url: "{{ route('admin.update.versions.categories3') }}",
            type: "POST",
            data: {
                category_name_color_cat3: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}

    });
});
     // Trigger the change event if the category is pre-selected
     if($('#all_categories_color_cat_3').val() !== ''){
        $('#all_categories_color_cat_3').trigger('change');
    }

    {{--  $('#all_subcategories_color_sub_cat_3').change(function() {
        var category_name = $('#all_categories_color_cat_3').val();
        var subcategory_id = $(this).val();

        $.ajax({
            url: "{{ route('admin.update.versions.categories3') }}",
            type: "POST",
            data: {
                category_name_color_cat3: category_name,
                photo_id: {{ $photo->id }},
                subcategory_id_color_cat3: subcategory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    });  --}}


    //blackcat1


    $(document).ready(function() {
    $('#all_categories_black_cat_1').change(function() {
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_black_sub_cat_1');
          if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');
            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories4') }}",
                type: "POST",
                data: {
                    category_name_black_cat1: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_black_cat1: null, // Reset subcategory
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}

            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                } else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                        subcategoriesSelect.removeAttr('disabled');
                        $.each(subcategories, function(index, subcategory) {
                            subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                        });
                        // Select the first option
                        subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                        subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });

        {{--  $.ajax({
            url: "{{ route('admin.update.versions.categories4') }}",
            type: "POST",
            data: {
                category_name_black_cat1: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}

    });
});
      // Trigger the change event if the category is pre-selected
      if($('#all_categories_black_cat_1').val() !== ''){
        $('#all_categories_black_cat_1').trigger('change');
    }


    {{--  $('#all_subcategories_black_sub_cat_1').change(function() {
        var category_name = $('#all_categories_black_cat_1').val();
        var subcategory_id = $(this).val();

        $.ajax({
            url: "{{ route('admin.update.versions.categories4') }}",
            type: "POST",
            data: {
                category_name_black_cat1: category_name,
                photo_id: {{ $photo->id }},
                subcategory_id_black_cat1: subcategory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });


    });  --}}

    {{--    --}}

    {{--  blackcat2  --}}
    $(document).ready(function() {
    $('#all_categories_black_cat_2').change(function() {
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_black_sub_cat_2');
          if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');
            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories5') }}",
                type: "POST",
                data: {
                    category_name_black_cat2: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_black_cat2: null,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}

            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                } else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                        subcategoriesSelect.removeAttr('disabled');
                        $.each(subcategories, function(index, subcategory) {
                            subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                        });
                        // Select the first option
                        subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                        subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });


{{--
        $.ajax({
            url: "{{ route('admin.update.versions.categories5') }}",
            type: "POST",
            data: {
                category_name_black_cat2: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}

    });
});
    // Trigger the change event if the category is pre-selected
    if($('#all_categories_black_cat_2').val() !== ''){
        $('#all_categories_black_cat_2').trigger('change');
    }

    {{--  $('#all_subcategories_black_sub_cat_2').change(function() {
        var category_name = $('#all_categories_black_cat_2').val();
        var subcategory_id = $(this).val();

        $.ajax({
            url: "{{ route('admin.update.versions.categories5') }}",
            type: "POST",
            data: {
                category_name_black_cat2: category_name,
                photo_id: {{ $photo->id }},
                subcategory_id_black_cat2: subcategory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });

    });  --}}

    {{--    --}}

     {{--  blackcat3  --}}
     $(document).ready(function() {
     $('#all_categories_black_cat_3').change(function() {
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_black_sub_cat_3');
      if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');
            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories6') }}",
                type: "POST",
                data: {
                    category_name_black_cat3: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_black_cat3: null,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}
            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                } else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                        subcategoriesSelect.removeAttr('disabled');
                        $.each(subcategories, function(index, subcategory) {
                            subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                        });
                        // Select the first option
                        subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                        subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });

        {{--  $.ajax({
            url: "{{ route('admin.update.versions.categories6') }}",
            type: "POST",
            data: {
                category_name_black_cat3: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}

    });
});
     // Trigger the change event if the category is pre-selected
     if($('#all_categories_black_cat_3').val() !== ''){
        $('#all_categories_black_cat_3').trigger('change');
    }

    {{--  $('#all_subcategories_black_sub_cat_3').change(function() {
        var category_name = $('#all_categories_black_cat_3').val();
        var subcategory_id = $(this).val();

        $.ajax({
            url: "{{ route('admin.update.versions.categories6') }}",
            type: "POST",
            data: {
                category_name_black_cat3: category_name,
                photo_id: {{ $photo->id }},
                subcategory_id_black_cat3: subcategory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });


    });  --}}



    //sepiacat1

    $(document).ready(function() {
    $('#all_categories_sepia_cat_1').change(function() {
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_sepia_sub_cat_1');
        if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');
            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories7') }}",
                type: "POST",
                data: {
                    category_name_sepia_cat1: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_sepia_cat1: null,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}
            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                } else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                        subcategoriesSelect.removeAttr('disabled');
                        $.each(subcategories, function(index, subcategory) {
                            subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                        });
                        // Select the first option
                        subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                        subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });

        {{--  $.ajax({
            url: "{{ route('admin.update.versions.categories7') }}",
            type: "POST",
            data: {
                category_name_sepia_cat1: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}

    });
});
     // Trigger the change event if the category is pre-selected
     if($('#all_categories_sepia_cat_1').val() !== ''){
        $('#all_categories_sepia_cat_1').trigger('change');
    }

    {{--  $('#all_subcategories_sepia_sub_cat_1').change(function() {
        var category_name = $('#all_categories_sepia_cat_1').val();
        var subcategory_id = $(this).val();

        $.ajax({
            url: "{{ route('admin.update.versions.categories7') }}",
            type: "POST",
            data: {
                category_name_sepia_cat1: category_name,
                photo_id: {{ $photo->id }},
                subcategory_id_sepia_cat1: subcategory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });


    });  --}}



    // sepiacat2
    $(document).ready(function() {
    $('#all_categories_sepia_cat_2').change(function() {
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_sepia_sub_cat_2');
        if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');
            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories8') }}",
                type: "POST",
                data: {
                    category_name_sepia_cat2: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_sepia_cat2: null,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}
            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                } else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                        subcategoriesSelect.removeAttr('disabled');
                        $.each(subcategories, function(index, subcategory) {
                            subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                        });
                        // Select the first option
                        subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                        subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });

        {{--  $.ajax({
            url: "{{ route('admin.update.versions.categories8') }}",
            type: "POST",
            data: {
                category_name_sepia_cat2: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}

    });
});
     // Trigger the change event if the category is pre-selected
     if($('#all_categories_sepia_cat_2').val() !== ''){
        $('#all_categories_sepia_cat_2').trigger('change');
    }

    {{--  $('#all_subcategories_sepia_sub_cat_2').change(function() {
        var category_name = $('#all_categories_sepia_cat_2').val();
        var subcategory_id = $(this).val();

        $.ajax({
            url: "{{ route('admin.update.versions.categories8') }}",
            type: "POST",
            data: {
                category_name_sepia_cat2: category_name,
                photo_id: {{ $photo->id }},
                subcategory_id_sepia_cat2: subcategory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    });  --}}





    // sepiacat3
    $(document).ready(function() {
    $('#all_categories_sepia_cat_3').change(function() {
        var category_name = $(this).val();
        var subcategoriesSelect = $('#all_subcategories_sepia_sub_cat_3');
        if(category_name === ""){
            subcategoriesSelect.empty();
            subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
            subcategoriesSelect.attr('disabled', 'disabled');
            {{--  $.ajax({
                url: "{{ route('admin.update.versions.categories9') }}",
                type: "POST",
                data: {
                    category_name_sepia_cat3: category_name,
                    photo_id: {{ $photo->id }},
                    subcategory_id_sepia_cat3: null,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });  --}}
            return;
        }

        $.ajax({
            url: "{{ url('admin/photossubcatname') }}"+ '/' +category_name,
            type: 'GET',
            success: function(subcategories) {
                subcategoriesSelect.empty();
                if (subcategories.length == 0) {
                    subcategoriesSelect.append($('<option>').val('').text('Keine Unterkategorie verfügbar'));
                    subcategoriesSelect.attr('disabled', 'disabled');
                } else {
                    subcategoriesSelect.append($('<option>').val('').text('Unterkategorie auswählen'));
                        subcategoriesSelect.removeAttr('disabled');
                        $.each(subcategories, function(index, subcategory) {
                            subcategoriesSelect.append($('<option>').val(subcategory.id).text(subcategory.name));
                        });
                        // Select the first option
                        subcategoriesSelect.find('option:eq(1)').attr('selected', 'selected');
                        subcategoriesSelect.trigger('change'); // trigger subcategory change event
                }
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });

        {{--  $.ajax({
            url: "{{ route('admin.update.versions.categories9') }}",
            type: "POST",
            data: {
                category_name_sepia_cat3: category_name,
                photo_id: {{ $photo->id }},
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });  --}}

    });
});
     // Trigger the change event if the category is pre-selected
     if($('#all_categories_sepia_cat_3').val() !== ''){
        $('#all_categories_sepia_cat_3').trigger('change');
    }

    {{--  $('#all_subcategories_sepia_sub_cat_3').change(function() {
        var category_name = $('#all_categories_sepia_cat_3').val();
        var subcategory_id = $(this).val();

        $.ajax({
            url: "{{ route('admin.update.versions.categories9') }}",
            type: "POST",
            data: {
                category_name_sepia_cat3: category_name,
                photo_id: {{ $photo->id }},
                subcategory_id_sepia_cat3: subcategory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                //console.log(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    });  --}}



    		$(document).ready(function() {
        		// Activate the history tabs.
                $('a[data-toggle="tab"]').historyTabs();
    		});

    +function ($) {
        'use strict';
        $.fn.historyTabs = function() {
            var that = this;
            window.addEventListener('popstate', function(event) {
                if (event.state) {
                    $(that).filter('[href="' + event.state.url + '"]').tab('show');
                }
            });
            return this.each(function(index, element) {
                $(element).on('show.bs.tab', function() {
                    var stateObject = {'url' : $(this).attr('href')};

                    if (window.location.hash && stateObject.url !== window.location.hash) {
                        window.history.pushState(stateObject, document.title, window.location.pathname + $(this).attr('href'));
                    } else {
                        window.history.replaceState(stateObject, document.title, window.location.pathname + $(this).attr('href'));
                    }
                });
                if (!window.location.hash && $(element).is('.active')) {
                    // Shows the first element if there are no query parameters.
                    $(element).tab('show');
                } else if ($(this).attr('href') === window.location.hash) {
                    $(element).tab('show');
                }
            });
        };
    }(jQuery);

        $(document).ready(function() {
            $('input[type=radio][name=status_C]').change(function() {
                var color_version_photo_id = $(this).val();
                var activeState = $(this).is(':checked') ? 'on' : 'off';

                // set the status of all items to off except for the selected one
                $('input[type=radio][name=status_C]').not(this).each(function() {
                    $(this).prop('checked', false);
                    $(this).next().text('off');
                    // send an AJAX request to update the status of the off items
                    var itemIdOff = $(this).val();
                    $.ajax({
                        url: "{{ route('admin.update.status1', ':id') }}".replace(':id', itemIdOff),
                        type: "POST",
                        data: {
                            status: 'off',
                            color_create_version: 'C',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            //console.log(response);
                        },
                        error: function(xhr, status, error) {
                            alert(xhr.responseText);
                        }
                    });
                });

                // set the status of the selected item to on
                $(this).prop('checked', true);
                $(this).next().text('on');

                // send an AJAX request to update the status of the selected item
                $.ajax({
                    url: "{{ route('admin.update.status1', ':id') }}".replace(':id', color_version_photo_id),
                    type: "POST",
                    data: {
                        status: activeState,
                        color_create_version: 'C',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        //console.log(response);
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
            });


            $('input[type=radio][name=status_B]').change(function() {
                var itemId = $(this).val();
                var activeState = $(this).is(':checked') ? 'on' : 'off';

                // set the status of all items to off except for the selected one
                $('input[type=radio][name=status_B]').not(this).each(function() {
                    $(this).prop('checked', false);
                    $(this).next().text('off');
                    // send an AJAX request to update the status of the off items
                    var itemIdOff = $(this).val();
                    $.ajax({
                        url: "{{ route('admin.update.status1', ':id') }}".replace(':id', itemIdOff),
                        type: "POST",
                        data: {
                            status: 'off',
                            color_create_version: 'B',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            //console.log(response);
                        },
                        error: function(xhr, status, error) {
                            alert(xhr.responseText);
                        }
                    });
                });

                // set the status of the selected item to on
                $(this).prop('checked', true);
                $(this).next().text('on');

                // send an AJAX request to update the status of the selected item
                $.ajax({
                    url: "{{ route('admin.update.status1', ':id') }}".replace(':id', itemId),
                    type: "POST",
                    data: {
                        status: activeState,
                        color_create_version: 'B',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        //console.log(response);
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
            });

            $('input[type=radio][name=status_S]').change(function() {
                var itemId = $(this).val();
                var activeState = $(this).is(':checked') ? 'on' : 'off';

                // set the status of all items to off except for the selected one
                $('input[type=radio][name=status_S]').not(this).each(function() {
                    $(this).prop('checked', false);
                    $(this).next().text('off');
                    // send an AJAX request to update the status of the off items
                    var itemIdOff = $(this).val();
                    $.ajax({
                        url: "{{ route('admin.update.status1', ':id') }}".replace(':id', itemIdOff),
                        type: "POST",
                        data: {
                            status: 'off',
                            color_create_version: 'S',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            //console.log(response);
                        },
                        error: function(xhr, status, error) {
                            alert(xhr.responseText);
                        }
                    });
                });

                // set the status of the selected item to on
                $(this).prop('checked', true);
                $(this).next().text('on');

                // send an AJAX request to update the status of the selected item
                $.ajax({
                    url: "{{ route('admin.update.status1', ':id') }}".replace(':id', itemId),
                    type: "POST",
                    data: {
                        status: activeState,
                        color_create_version: 'S',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        //console.log(response);
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
            });




        });

    function deleteVersionPhoto(id){
        if(confirm("Sind Sie sicher, dass Sie diese Version des Fotos löschen möchten?")){
            $.ajax({
                url: "{{ url('admin/delete/version/photo') }}/"+id,
                type: 'GET',
                success: function(response){
                    if(response.status == true){
                        location.reload();
                    }
                }
            });
        }
    }







</script>


@endsection
