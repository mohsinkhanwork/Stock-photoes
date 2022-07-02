@extends('layouts.admin')
@section('content')

<style>
.table td {
    height: 28px !important;
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
                    <h3 class="card-title">Kategorien</h3>
                    <div class="float-right">
                        <a href="{{ route('admin.create.categories') }}" class="btn btn-primary" style="font-size: 13px;">
                            Kategorie hinzufügen
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">


            {{-- @include('admin.layouts.session_message') --}}
            <table class="table table-striped table-bordered "style="width:100%;text-align: center;">
         <thead>
         <tr>
             {{-- <th class="no-sort" style="text-align: right; padding-right: 12px; width: 30px;">#</th> --}}
             <th style="text-align: right; padding-right: 12px; width: 30px;" class="active_column">ID</th>
             <th>Name</th>
             <th>Status</th>

             <th class="no-sort">Action</th>
         </tr>
         </thead>
         <tbody>
         @foreach($categories as $category)
             <tr>
                 {{-- <td><p style="text-align: right;margin: 0px">{{ $loop->index+1 }}</p></td> --}}
                 <td><p style="text-align: right;margin: 0px">{{$category->id}}</p></td>
                 <td>{{$category->name}}</td>
                 <td>{{$category->status}}</td>

                 <td>
                     <a href="{{ route('admin.edit.categories', [$category->id] ) }}"
                        style="cursor: pointer;color: black">
                        <i class="fa fa-pen"></i></a>&nbsp;&nbsp;
                     <a href="{{ route('admin.delete.categories', [$category->id]) }}" style="cursor: pointer"
                            class="OpenModal">
                            <i class="fa fa-trash" style="color: red;"></i></a>
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
