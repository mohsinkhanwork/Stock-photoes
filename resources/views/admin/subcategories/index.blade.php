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
                    <h3 class="card-title">Sub Categories</h3>
                    <div class="float-right">
                        <a href="{{ route('admin.create.subcategories') }}" class="btn btn-primary">
                            create sub categories
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">


            {{-- @include('admin.layouts.session_message') --}}
            <table class="table table-striped table-bordered "style="width:100%">
         <thead>
         <tr>
             {{-- <th class="no-sort" style="text-align: right; padding-right: 12px; width: 30px;">#</th> --}}
             <th style="text-align: right; padding-right: 12px; width: 30px;" class="active_column">ID</th>
             <th>Name</th>
             <th>Image</th>
             <th>Image title</th>
             <th>Image price</th>
             <th>Parent Category </th>

             <th class="no-sort">Action</th>
         </tr>
         </thead>
         <tbody>
         @foreach($subcategories as $subcategory)
             <tr>
               <td><p style="text-align: right;margin: 0px">{{$subcategory->id}}</p></td>
                 <td>{{$subcategory->name}}</td>
                 <td style="text-align: center;">
                     <img src="{{ asset( '/storage/subcategories/'.$subcategory->image) }}" style="width: 230px;">
                </td>
                 <td>{{$subcategory->image_title}}</td>
                 <td>{{$subcategory->image_price}}</td>
                 <td>{{$subcategory->Category->name}}</td>


                 <td>
                     <a href="{{ route('admin.edit.subcategories', [$subcategory->id] ) }}"
                        style="cursor: pointer;color: black">
                        <i class="fa fa-pen"></i>
                    </a>&nbsp;&nbsp;
                     <a href="{{ route('admin.delete.subcategories', [$subcategory->id]) }}" style="cursor: pointer"
                            class="OpenModal">
                            <i class="fa fa-trash" style="color: red"></i>
                        </a>
                 </td>
             </tr>
         @endforeach
         </tbody>

        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
