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
                            Kategorie hinzuf&#252;gen
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row"></div>
                <table class="table table-striped table-bordered data_table_yajra" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align: right; padding-right: 12px; width: 30px;">
                                #
                            </th>
                            <th style="text-align: center">Aktiv?</th>
                            <th style="text-align: center">Bild</th>
                            <th>Name</th>
                            <th>Sortierung</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

        <script type="text/javascript">
            $(function () {

              var table = $('.data_table_yajra').DataTable({
                  processing: true,
                  serverSide: true,
                  bInfo: true,
                  paging: false,
                  bPaginate: false,
                  ajax: "{{ route('admin.getAllCatJson') }}",
                  columns: [
                      {data: 'id', name: 'id'},
                      {data: 'status', name: 'status'},
                      {data: 'image', name: 'image'},
                      {data: 'name', name: 'image'},
                  ]
              });

            });
          </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
