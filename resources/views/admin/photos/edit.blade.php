@extends('layouts.admin')

@section('content')
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
                    <h3 class="card-title"> Unterkategorie hinzuf&#252;gen </h3>
                </div>

    <form method="POST" action="{{ route('admin.update.photos') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="category_id" value="{{ $category_id }}">
    <input type="hidden" name="id" value="{{ $photo->id }}">

    <div class="card-body">

        <div class="form-group" style="width: 100%;display: flex;">
            <label style="width: 20%;"> Aktiv? <code>*</code></label>
            <div style="width: 30%;">
                <input type="checkbox" style="display: block;" name="status" @if($photo->status == 'on') checked @endif>
            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Beschreibung <code>*</code></label>
                <div style="width: 30%;">
                    <input type="text" required class="form-control" name="description" autofocus
                    @if(old('description'))
                       value="{{old('description')}}"
                       @elseif(isset($photo->description))
                       value="{{$photo->description}}"
                       @endif>

                </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="category_id" class="col-form-label" style="width: 20%;"> Unterkategorie zuweisen <code>*</code></label>
            <div style="width: 30%;">

                {!! Form::select('sub_category_id', $sub_categories, null, ['class' => 'form-control']) !!}

            </div>
        </div>

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="category_id" class="col-form-label" style="width: 20%;"> Upload <code>*</code></label>
           <div style="width: 30%;">
            <div class="input-group control-group increment">
                <input type="file" name="image[]" class="form-control">
                <div class="input-group-btn">
                  <button class="btn btn-primary AddMoreFiles" type="button">
                    <i class="glyphicon glyphicon-plus"></i>
                    mehr hinzufügen
                </button>
                </div>
              </div>
              <div class="clone hide">
                <div class="control-group input-group" style="margin-top:10px">
                  <input type="file" name="image[]" class="form-control">
                  <div class="input-group-btn">
                    <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i>
                        entfernen
                    </button>
                  </div>
                </div>
              </div>
           </div>

        </div>  --}}

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> Bild <code>*</code></label>
            <div style="width: 30%;">

                <img src=" {{ asset('/storage/photos/originalImage/'.$photo->original_image) }} "
                style="object-fit: cover;width: 100%;border: 1px solid lightgrey;">

            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> hochgeladenes Datum <code>*</code></label>
            <div style="width: 30%;">

                <p style="font-weight: bold;">
                    {{ $photo->created_at }}
                </p>

            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> Upload <code>*</code>
            </label>
            <div style="width: 30%;">
                <label for="inputTag1">
                    <i class="btn btn-primary" style="font-style: inherit;font-size: 14px;">Upload</i>
                    <input id="inputTag1" type="file"/ name="image">
                    <span id="imageName1" style="font-weight: 400">Keine Datei ausgewählt</span>
                  </label>
            </div>
        </div>

            </div>
<div class="card-footer" style="text-align: right;">
<a href="{{ route('admin.photos', [$category_name]) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
    Abbrechen
</a>
    <button type="submit" class="btn btn-primary btn-sm filterButton" style="font-size: 13px;"> Unterkategorie erstellen </button>

</div>

</form>
        </div>
    </div>
</div>

{{--  <script type="text/javascript">

    $(document).ready(function() {

      $(".AddMoreFiles").click(function(){
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){
          $(this).parents(".control-group").remove();
      });

    });

</script>  --}}


{{--  <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   $('#upload-image-form').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       $('#image-input-error').text('');
       $('#image-input-error2').text('');

       $.ajax({
          type:'POST',
          url: "{{ route('admin.store.subcategories') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               this.reset();

            swal({
                title: "Congratualtions!",
                text: "Image has been uploaded successfully",
                icon: "success",
                buttons: "OK",
                })
                .then((willDelete) => {
                if (willDelete) {

                    window.location.href = "{{ route('admin.subcategories') }}";
                }
                });

             }
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
                $('#image-input-error2').text(response.responseJSON.errors.file);
           }
       });
  });

</script>  --}}

<script>
    let input = document.getElementById("inputTag1");
    let imageName = document.getElementById("imageName1")

    input.addEventListener("change", ()=>{
        let inputImage1 = document.querySelector("input[type=file]").files[0];

        imageName.innerText = inputImage1.name;
    })

</script>

@endsection
