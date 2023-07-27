@extends('admin.layouts.app')
@include('admin.layouts.dataTableStyle')
@section('content')
    <section class="content-header">

        <div class="container-fluid">

            @if ($message = Session::get('success'))
                <div class="alert alert-success text-center">
                    <!-- you missed this line of code -->
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> {{ $message }}
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>{{ $page_name }} Management</h2>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $page_name }} Management</li>
                    </ol>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- general form elements -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Filter {{ $page_name }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">
                <div class="col-xs-12 col-sm-12 col-md-12 row">

                    <div class="form-group col-md-4">
                        <strong>Title </strong>
                        <input id="filter_title" placeholder="Title" required class="form-control" name="name"
                            type="text">
                    </div>
                    <div class="form-group col-md-4">
                        <strong>Status </strong>
                        <div class="form-group">
                            <select id="filter_status" class="form-control select2 select2-hidden-accessible" name="status"
                                style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">-- Select --</option>
                                <option value="1">Activate</option>
                                <option value="0">Deactivate </option>
                            </select>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">{{ $page_name }} List</h3>
                @can($permission . '-create')
                    <div class="ml-auto">
                        <a class="btn btn-success btn-sm" href="{{ route('plan.create') }}">Create New {{ $page_name }}</a>
                    </div>
                @endcan

            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped  tag_tbl">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Day</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection('content')
@section('scripts')
    @include('admin.layouts.dataTableScripts')
    <script>
        var table = "";

        $(function() {

            table = $('.tag_tbl').DataTable({
             
        searchBuilder: true, // Enable the search builder plugin
     
                processing: true,
                serverSide: true,
                lengthChange: true,
                autoWidth: false,
                "iDisplayLength": 10,
                
                ajax: {
                    url: "{{ route('plan.index') }}",
                    data: function(d) {
                        d.status = $('#filter_status').val()
                        d.title = $('#filter_title').val()
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'day',
                        name: 'day'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        "targets": 1,
                        "className": "text-center",
                    },
                    {
                        "targets": 2,
                        "className": "text-center",
                    },
                    {
                        "targets": 3,
                        "className": "text-center",
                    },
                    {
                        "targets": 4,
                        "className": "text-center",
                    },
                    {
                        "targets": 5,
                        "className": "text-center",
                    },
                    {
                        "targets": 6,
                        "className": "text-center",
                    },

                ],
            });

               });

        $('#filter_status').change(function() {
            table.draw();
        });
        $('#filter_title').keyup(function() {
            table.draw();
        });

    
           
    </script>
@endsection

<!-- /.content-wrapper -->
