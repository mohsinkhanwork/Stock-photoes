@extends('layouts.admin')

@section('content')
{{--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  --}}
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

      .error {
        border: 1.5px solid #dc3545;
        position: relative;
        background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") no-repeat scroll right .8em center/16px 16px;
        padding-right: 25px; /* to prevent text overlap */
    }

    .error-message {
        color: #dc3545;
        font-weight: bold;
        font-size: 80%;
    }
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    {{--  @if (count($errors) > 0)
      <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
            {{ $error }}
          @endforeach
      </div>
      @endif  --}}

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Fotoverwaltung Upload </h3>
                </div>

{{--  <form method="POST" action="{{ route('admin.store.subcategories') }}" id="upload-image-form" enctype="multipart/form-data">  --}}

    <form method="POST" action="{{ route('admin.store.photos') }}" enctype="multipart/form-data" id="photoForm">
    @csrf
    {{--  <input type="hidden" name="category_id" value="{{ $category_id }}">  --}}
    <div class="card-body" style="padding-bottom: 0px;">

        <input type="hidden" name="category" value="{{ request()->query('category') }}">
    <input type="hidden" name="subcategory" value="{{ request()->query('subcategory') }}">

        <div class="form-group" style="width: 104%;display: flex;">
            <div style="width: 50%;display: flex;">
                <label for="all_categories" style="width: 24%;"> Kategorie 1 </label>
                <div style="width: 59%;">
                    <select id="all_categories" class="form-control" name="category" required>
                        <option value="">Kategorie auswählen</option>
                        @foreach ($all_categories as $category)
                            <option value="{{ $category->name }}" {{ request('category') === $category->name ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div style="width: 50%;display: flex;">
                <label style="width: 32.5%;"> Unterkategorie 1 <code> * </code> </label>
                <div style="width: 59%;">
                    <select id="all_subcategories" class="form-control" name="subcategory">
                    </select>
                    <div id="subcategoryError" class="error-message"></div>
                    {{--  @if ($errors->has('subcategory'))
                        <span class="text-danger" style="font-weight: bold;font-size: 14px;">{{ $errors->first('subcategory') }}</span>
                    @endif  --}}
                </div>
            </div>
        </div>

        <div class="form-group" style="width: 104%;display: flex;">
            <div style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 24%;"> Titel </label>
                <div style="width: 59%;">
                    <input type="text" class="form-control" name="title" autofocus id="title" value="{{ old('title') }}">
                    <div id="titleError" class="error-message"></div>
                    {{--  @if ($errors->has('title'))
                    <span class="text-danger" style="font-weight: bold;font-size: 14px;">{{ $errors->first('title') }}</span>
                @endif  --}}
                </div>
            </div>

            <div style="width: 100%;display: flex;">
                <label for="color" class="col-form-label" style="width: 32.5%;"> Farbton</label>
                <div style="width: 59%;">
                    <select name="color_create_version" class="form-control" required>
                        <option value="C">Farbe</option>
                        <option value="B">Schwarz/Weiß</option>
                        <option value="S">Sepia</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group" style="width: 104%;display: flex;">
            <div style="width: 50%; display: flex">
                <label for="original_medium" class="col-form-label" style="width: 24%;"> Original-Medium </label>
            <div style="width: 59%;">

                <input type="radio" name="type" value="Digitalfoto" style="display:inline-table; margin-top: 13px;" checked id="option1">
                    <label for="option1" style="display:inline-table; margin-left:35px;font-weight: 500;">Digitalfoto</label>

                <div style="display: flex">
                    <input type="radio" name="type" value="" style="display:inline-table" id="option3">
                <select class="form-control" id="option3-select" style="margin-left:35px;">
                    <option>Select</option>
                    <option value="Daguerreotype">Daguerreotype</option>
                    <option value="Ambrotype">Ambrotype</option>
                    <option value="Tintype">Tintype</option>
                    <option value="Salt Print">Salt Print</option>
                    <option value="Albumen">Albumen</option>
                    <option value="Gelatine Silver Print">Gelatine Silver Print</option>
                    <option value="Card de Visite (CDV)">Card de Visite (CDV)</option>
                    <option value="Cabinet Card">Cabinet Card</option>
                    <option value="Magic Lantern">Magic Lantern</option>
                    <option value="Sketch B/W">Sketch B/W</option>
                    <option value="Sketch Colour">Sketch Colour</option>
                    <option value="Stereoview Daguerreotype">Stereoview Daguerreotype</option>
                    <option value="Stereoview Albumen">Stereoview Albumen</option>
                    <option value="Postcard">Postcard</option>
                    <option value="Cigarette Cards">Cigarette Cards</option>
                    <option value="Video">Video</option>
                </select>
                <br />
                <br />
                </div>

                <div style="margin-left: 47px; margin-top: 14px;">

                    <p>
                      <span style="font-weight: bold;">Original-Format</span>
                      <label for="Hohe" style="margin-left: 13px; font-weight: 500;">Höhe</label>
                      <input type="text" name="OF_height" class="form-control" style="display:inline-table; width: 60px;"> cm
                      <label for="Breite" style="margin-left: 23px; font-weight: 500;">Breite</label>
                      <input type="text" name="OF_width" class="form-control" style="display:inline-table;width: 60px;"> cm
                    </p>

                    <p>
                      <label for="Ek-Preis">EK-Preis</label>
                      <input type="text" name="EK_price" class="form-control" style="display:inline-table;width: 20%;margin-left: 9px;">
                      <label for="EK-Jahr" style="margin-left: 11px;">EK-Jahr</label>
                      <input type="text" name="EK_year" class="form-control" style="display:inline-table; width: 20%;margin-left: 10px;">
                    </p>

                  </div>


            </div>
            </div>
            <div style="width: 50%;    margin-top: 44px;">
                <div>
                    <label for="weather" class="col-form-label"> SEO/Such-tags </label>
                </div>
                <div style="display: flex;">
                    <label for="weather" class="col-form-label" style="width: 32.5%;"> Wetter </label>
                    <select id="weather" class="form-control" name="weather" style="width: 59%;">
                        <option value="Sunny"> Sunny </option>
                        <option value="Sunset"> Sunset </option>
                        <option value="Sunrise"> Sunrise </option>
                        <option value="Cloudy"> Cloudy </option>
                        <option value="Foggy"> Foggy </option>
                        <option value="Snow"> Snowy </option>
                    </select>
                </div>
                <br />
                <div style="display: flex;">
                    <label for="season" class="col-form-label" style="width: 32.5%;"> Jahreszeit </label>
                    <select id="season" class="form-control" name="season" style="width: 59%;">
                        <option value="Summer"> Summer </option>
                        <option value="Autumn"> Autumn </option>
                        <option value="Winter"> Winter </option>
                        <option value="Spring"> Spring </option>
                    </select>
                </div>
            </div>

        </div>

        <div class="form-group" style="width: 104%;display: flex;">
            <label for="name" class="col-form-label" style="width: 15%;"> Image-Jahr </label>
            <div style="width: 7%;">
                <input type="text" class="form-control" name="image_year" autofocus>
            </div>

        </div>

        <div class="form-group" style="width: 104%;display: flex;">
            <label for="photographer" class="col-form-label" style="width: 12%;"> Fotograf </label>
            <div style="width: 31.5%;">
                <input type="radio" name="photographer" value="Harald Hochmann" checked style="display:inline-table" id="photographer1">
                    <span style="margin-left: 33px;">
                       Harald Hochmann
                    </span>

                <br />
                <input type="radio" name="photographer" value="Unbekannt (Public Domain)" style="display:inline-table" id="photographer2">

                <span style="margin-left: 33px;">
                    Unbekannt (Public Domain)
                </span>
                <br />
                <input type="radio" name="photographer" value="" style="display:inline-table;margin-top: 17px;" id="photographer3"> &nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" style="display:inline-table; width: 57.5%;margin-left: 23px;margin-top: 7px;" id="photographer3-input"> &nbsp;&nbsp; (Public Domain)

            </div>
        </div>

        <div class="form-group" style="width: 104%;display: flex;">
            <label for="description" class="col-form-label" style="width: 12.06%;"> Bescchreibung </label>
            <div style="width: 83.5%;">
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group" style="width: 104%;display: flex;">
            <label for="image" class="col-form-label" style="width: 12%;"> Foto
            </label>
            <div style="width: 84%;">
                <label for="inputTag1">
                    <i class="btn btn-primary" style="font-style: inherit;font-size: 14px;">Upload</i>
                    <input id="inputTag1" type="file"/ name="image">
                    <span id="imageName1" style="font-weight: 400">Keine Datei ausgew&#xe4;hlt</span>
                  </label>
                  <div>
                    @if ($errors->has('image'))
                <span class="text-danger" style="font-weight: bold;font-size: 14px;">{{ $errors->first('image') }}</span>
            @endif
                    </div>
            </div>
        </div>

            </div>
<div class="card-footer" style="text-align: right;padding-right: 1%;">
{{--  <a href="{{ route('admin.photos', [$category_name]) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
    Abbrechen
</a>  --}}
<a href="{{ route('admin.photos') }}?{{ http_build_query(request()->query()) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
    Abbrechen
</a>

    <button type="submit" class="btn btn-primary btn-sm filterButton" style="font-size: 13px;"> Foto erstellen </button>

</div>

</form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#photoForm').on('submit', function (e) {
            // Clear error states
            $('#title, #all_subcategories').removeClass('error');
            $('.error-message').text('');

            let title = $('#title').val().trim();
            let subcategory = $('#all_subcategories').val().trim();

            if (title === '') {
                e.preventDefault();
                $('#title').addClass('error');
                $('#titleError').text('Titel muss ausgefüllt werden');
            }

            if (subcategory === '') {
                e.preventDefault();
                $('#all_subcategories').addClass('error');
                $('#subcategoryError').text('Unterkategorie muss ausgewählt werden');
            }
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let input = document.getElementById("inputTag1");
    let imageName = document.getElementById("imageName1")

    input.addEventListener("change", ()=>{
        let inputImage1 = document.querySelector("input[type=file]").files[0];

        imageName.innerText = inputImage1.name;
    })


    $('#all_categories').change(function() {
        var subcategoriesSelect = $('#all_subcategories');
        subcategoriesSelect.empty();
        fetchSubcategoriesForCategory();
    });

    var selectedCategory = decodeURIComponent("{{ rawurlencode(request('category')) }}");
    {{--  console.log(selectedCategory);  --}}
    $('#all_categories').val(selectedCategory);
    {{--  $('#all_categories').change(); // Trigger the change event manually  --}}

    const option3Radio = document.querySelector('#option3');
    const option3Select = document.querySelector('#option3-select');

    // Add a change event listener to the select element
    option3Select.addEventListener('change', (event) => {
      // When an option is selected, set the value of the radio button to the selected value
      option3Radio.value = event.target.value;
    });

    const photographerInput = document.getElementById("photographer3-input");
    const photographerRadio = document.getElementById("photographer3");

photographerInput.addEventListener("input", function() {
  photographerRadio.value = photographerInput.value;
});

// get the sub name from the url

var urlParams = new URLSearchParams(window.location.search);
var subcategoryId = urlParams.get('subcategory');

// Function to fetch subcategory name based on subcategoryId
function fetchSubcategoryName(subcategoryId) {
    if (!subcategoryId) {
        return;
    }

    $.ajax({
        url: "{{ route('admin.getSubcategoryName1', ':id') }}".replace(':id', subcategoryId),
        type: 'GET',
        success: function(subcategoryName) {
            // Get the container element for the dropdown
            var subcategoriesSelect = $('#all_subcategories');

            // Add an option for the selected subcategory
            var selectedOption = $('<option>').val(subcategoryId).text(subcategoryName);
            subcategoriesSelect.append(selectedOption);

            // Fetch all other subcategories for the category
            fetchSubcategoriesForCategory();
        },
        error: function() {
            alert('Error fetching subcategory name');
        }
    });
}

// New function to fetch all subcategories under the selected category
function fetchSubcategoriesForCategory() {
    var category_name = $('#all_categories').val();
    var selectedSubcategoryId = "{{ request('subcategory') }}";
    $.ajax({
        url: "{{ url('admin/photossubcatname') }}"+ '/' + category_name,
        type: 'GET',
        success: function(subcategories) {
            var subcategoriesSelect = $('#all_subcategories');

            // Append "Please select sub cat" option if no subcategory is selected
            if (!selectedSubcategoryId) {
                var defaultOption = $('<option>').val('').text('Unterkategorie auswählen');
                subcategoriesSelect.append(defaultOption);
            }

            // Append options for all subcategories
            $.each(subcategories, function(index, subcategory) {
                // Check if the subcategory id matches the selected one
                if (subcategory.id != selectedSubcategoryId) {
                    var option = $('<option>').val(subcategory.id).text(subcategory.name);
                    subcategoriesSelect.append(option);
                }
            });
        },
        error: function() {
            alert('Error fetching subcategories');
        }
    });
}

{{--  function fetchAllSubcategories() {
    var category = $('#all_categories').val();

    if (category) {
        $.ajax({
            url: "{{ route('admin.getAllSubcategories') }}",
            type: 'GET',
            data: {
                category: category
            },
            success: function(subcategories) {
                var subcategoriesSelect = $('#all_subcategories');

                // Add options for all subcategories
                $.each(subcategories, function(index, subcategory) {
                    var option = $('<option>').val(subcategory.id).text(subcategory.name);
                    subcategoriesSelect.append(option);
                });
            },
            error: function() {
                alert('Error fetching subcategories');
            }
        });
    }
}  --}}

// Fetch subcategory name if subcategoryId is present in the URL
var subcategoryId = "{{ request('subcategory') }}";
if (subcategoryId) {
    fetchSubcategoryName(subcategoryId);
} else {
    // Fetch all subcategories when no subcategoryId is present
    fetchSubcategoriesForCategory();
}

$('#all_subcategories').change(function() {
    var selectedSubcategoryId = $(this).val();

    if (selectedSubcategoryId) {
        // Update the URL with the selected subcategory ID
        var url = new URL(window.location.href);
        url.searchParams.set('subcategory', selectedSubcategoryId);
        window.history.replaceState(null, null, url.toString());
    } else {
        // Remove the subcategory parameter from the URL if no option is selected
        var url = new URL(window.location.href);
        url.searchParams.delete('subcategory');
        window.history.replaceState(null, null, url.toString());
    }
});


// ends here

</script>




@endsection
