@extends('layouts.admin')
@section('content')

<style>
    input{
  display: none;
}

label{
    cursor: pointer;
}

#imageName{
        color:green;
      }

#imageName2{
        color: black;
}
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Edit Sub Categories</h3>
                </div>

<form method="post" action="{{route('admin.update.subcategories',  [$SubCategory->id]) }} " enctype="multipart/form-data">
    @csrf

    <div class="card-body">
        {{-- @include('admin.layouts.session_message') --}}
        <input type="hidden" value="{{ $SubCategory->id }}" name="id" >

        <div class="form-group" style="width: 100%;display: flex;">
            <label style="width: 30%;"> Aktiv? <code>*</code></label>
            <div style="width: 70%;">
                <input type="checkbox" style="display: block;" name="status">
            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="name" class="form-label" style="width: 30%;"> Unterkategorie-Name  <code>*</code></label>
            <div style="width: 70%;">
                <input required class="form-control @error('name') is-invalid @enderror" name="name"
                       @if(old('name'))
                       value="{{old('name')}}"
                       @elseif(isset($SubCategory->name))
                       value="{{$SubCategory->name}}"
                       @endif>
            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="form-label" style="width: 30%;"> Select Image <code>*</code></label>
            <div style="width: 70%;">

                <div class="" style="width: 70%;">

                    <label for="inputTag">
                        <i class="fa fa-2x fa-camera"></i>
                        <input id="inputTag" type="file"/ name="image">
                        <span id="imageName"></span>

                      </label>

                    @if ($errors->has('image'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                @endif
                </div>

                @if ($errors->has('image'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                @endif

            </div>

        </div>

        <div class="form-group" style="width: 100%;display: flex;">
          <label class="form-label" style="width: 30%;"> Image title <code>*</code></label>
          <div style="width: 70%;">
            <input required class="form-control @error('image_title') is-invalid @enderror" name="image_title"
                   @if(old('image_title'))
                   value="{{old('image_title')}}"
                   @elseif(isset($SubCategory->image_title))
                   value="{{$SubCategory->image_title}}"
                   @endif>

        </div>
      </div>

      <div class="form-group" style="width: 100%;display: flex;">
        <label class="form-label" style="width: 30%;"> Image Price <code>*</code></label>
        <div style="width: 70%;">
          <input required class="form-control @error('image_price') is-invalid @enderror" name="image_price"
                 @if(old('image_price'))
                 value="{{old('image_price')}}"
                 @elseif(isset($SubCategory->image_price))
                 value="{{$SubCategory->image_price}}"
                 @endif>

      </div>
    </div>

    <div class="form-group" style="width: 100%;display: flex;">
        <label for="category_id" class="form-label" style="width: 30%;"> Select Parent Category <code>*</code></label>
        <div style="width: 70%;">

            {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}


        </div>
    </div>


    </div>
    <div class="card-footer" style="text-align: center;">
      <a href="{{ route('admin.subcategories') }}" class="btn btn-default btn-sm filterButton"
      style="border-color: #ddd">
          cancel
      </a>
        <button type="submit" class="btn btn-primary btn-sm"> Update </button>

    </div>
</form>

            </div>
        </div>
    </div>
</div>

<script>
    let input = document.getElementById("inputTag");
    let imageName = document.getElementById("imageName")

    input.addEventListener("change", ()=>{
        let inputImage = document.querySelector("input[type=file]").files[0];

        imageName.innerText = inputImage.name;
    })

    //logo
    let input2 = document.getElementById("inputTag2");
    let imageName2 = document.getElementById("imageName2")

    input2.addEventListener("change", ()=>{
        let inputImage2 = document.querySelector("#inputTag2").files[0];

        imageName2.innerText = inputImage2.name;
    })
</script>

@endsection