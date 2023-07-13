@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    @if(session('success'))
   <div class="alert alert-success" style="padding: 13px 10px 12px 36px">
      {{ session('success') }}
   </div>
 @endif

    <div class="content">

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="margin-top: 7px;"> Fotoverwaltung Übersicht </h3>
                    <div class="float-right col-md-5" style="text-align: right">
                        <a id="uploadButton" class="btn btn-primary" style="font-size: 13px;">
                            Foto hochladen
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-search input-group">
                                <select id="yajraSearch" class="form-control">
                                    <option value="">Kategorie auswählen</option>
                                        @if ($category_name == '')
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->name }}" {{ request('category') === $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                        @else
                                        <option value="{{ $category_name }}">{{ $category_name }}</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->name }}" {{ request('category') === $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                        @endif
                                </select>
                                &nbsp;

                                <select id="subcategorySelect" class="form-control">
                                    <option value="">Unterkategorie auswählen</option>
                                </select>

                                </select>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary yajraBtnSearch">Suchen</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1"></div>

                    </div>
            <table class="table table-striped table-bordered data_table_yajra"
                data-url="{{route('admin.getAllPhotos')}}"
                    data-length="{{$page_length}}"
                    data-custom-order="5"
                    data-table-show="1"
                    data-custom-sort-type="asc"
                    data-table-name="logo-table"
                    style="width:100%;    font-size: 13px !important;">
         <thead>
         <tr>
            @foreach($columns as $column_key=>$column_val)
                            <th data-column="{{$column_key}}"
                            @if(isset($column_val['type']))
                            data-custom-type="{{$column_val['type']}}"
                            @endif
                            @if($column_val['name'] == '#')
                            style="text-align: right !important; padding-right: 6px; width:25px;"
                            @endif
                            @if($column_val['name'] == 'Foto-ID')
                            style="width: 45px;"
                            @endif
                            @if($column_val['name'] == 'Foto')
                            style="width: 153px;text-align: center;"
                            @endif
                            @if($column_val['name'] == 'Aktiv')
                            style="text-align: center !important; width:35px; padding-left: 12px !important;"
                            @endif
                            @if($column_val['name'] == 'Version')
                            style="width:140px;"
                            @endif
                            @if($column_val['name'] == 'Unterkategorie')
                            style="width: 140px;"
                            @endif
                            @if($column_val['name'] == 'Hinzugefügt')
                            style="width:151px;"
                            @endif
                            @if($column_val['name'] == 'Aktion')
                            style="width:44px;"
                            @endif
                            @if(!$column_val['sort']) class="no-sort" @endif
                            data-sort="{{$column_val['sort']}}">{!! $column_val['name'] !!}
                        </th>
            @endforeach
         </tr>
         </thead>
         <tbody>
         </tbody>

        </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function updatePhoto(id, newText){
        var category_name       = $('select option:selected').val();
        var url = '{{ route("admin.getCatName.photos", ":name") }}';
        url = url.replace(':name', category_name);

            $.ajax({
                        type:"get",
                        url: url,
                        dataType: 'json',
                        success:function(response){
                            var category_name = response.name;
                            var url2 = "{{ url('admin/create/photos') }}?category=" + category_name + "&subcategory=" + newText;
                            window.location.href= url2;
                        }
              });
          }

          $(document).ready(function() {
            $('#yajraSearch').change(function() {
                var category_name = $(this).val();
                fetchSubcategories(category_name);
            });

            function fetchSubcategories(categoryName) {
                $.ajax({
                    url: "{{ url('admin/fetch-subcategories') }}",
                    type: 'GET',
                    data: {
                        category: categoryName
                    },
                    success: function(subcategories) {
                        var $select = $('#subcategorySelect');
                        $select.empty();

                        // Add the first empty option
                        $select.append($('<option>', { value: "", text: "Unterkategorie auswählen" }));

                        $.each(subcategories, function(index, subcategory) {
                            $select.append($('<option>', { value: subcategory.id, text: subcategory.name }));
                        });

                        updateUploadButton();
                    },
                    error: function() {
                        alert('Error fetching subcategories');
                    }
                });
            }

            var selectedCategory = decodeURIComponent("{{ rawurlencode(request('category')) }}");
            $('#yajraSearch').val(selectedCategory);
            $('#yajraSearch').change(); // Trigger the change event manually

            $('#yajraSearch, #subcategorySelect').change(updateUploadButton);

            function updateUploadButton() {
                var category_name = $('#yajraSearch').val();
                var subcategory_id = $('#subcategorySelect').val();

                // Construct the URL with the selected category and subcategory
                var url = "{{ route('admin.create.photos') }}";
                var params = { category: category_name };
                if (subcategory_id) {
                    params.subcategory = subcategory_id;
                }

                // Set the query parameters in the URL
                url += '?' + $.param(params);

                // Set the constructed URL as the href attribute of the anchor tag
                $('#uploadButton').attr('href', url);
            }
        });

        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var category = urlParams.get('category');
            var subcategory = urlParams.get('subcategory');

            $('#yajraSearch').val(category);

            if (category) {
                fetchSubcategories(category, subcategory);
            }

            updateUploadButton();

        });

</script>

@endsection
