@extends('layouts.admin')

@section('content')


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">add Categories</h3>
                </div>

<form method="POST" action="{{ route('admin.store.categories') }}" enctype="multipart/form-data">
    @csrf

    <div class="card-body">

        {{-- @include('admin.layouts.session_message') --}}

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Category Name <code>*</code></label>
            <div class="col-sm-4">
                <input required class="form-control @error('name') is-invalid @enderror" name="name"
                       @if(old('name'))
                       value="{{old('name')}}"
                       @elseif(isset($user->name))
                       value="{{$user->name}}"
                       @endif>
                @error('name')
                <span class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label"> Select Status <code>*</code></label>
            <div class="col-sm-4">
                <select name="status" class="form-control">
                    <option value="active"> Active </option>
                    <option value="inActive"> In Active </option>

                </select>
                @error('status')
                    <span class="invalid-feedback error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label"> Select category image <code>*</code></label>
            <div class="col-sm-4">
                <input type="file" required class="form-control @error('image') is-invalid @enderror" name="image">
                @error('image')
                <span class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>


        </div>


    </div>
<div class="card-footer">
<a href="{{ route('admin.categories') }}" class="btn btn-default btn-sm float-right filterButton" style="border-color: #ddd">
    cancel
</a>
    <button type="submit" class="btn btn-primary btn-sm float-right"> Create Category </button>

</div>


</form>
        </div>
    </div>
</div>

@endsection
