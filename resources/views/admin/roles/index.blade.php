@extends('admin.layouts.app')
@include('admin.layouts.dataTableStyle')
@section('content')


<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
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
                <h2>{{$page_name}} Management</h2>

            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">{{$page_name}} Management</li>
                </ol>
            </div>
        </div>
       
           
           
            
       
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">



    <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">{{$page_name}} List</h3>
    @can($permission.'-create')
    <div class="ml-auto">
        <a class="btn btn-success btn-sm" href="{{ route('roles.create') }}">Create New {{$page_name}}</a>
    </div>
    @endcan
</div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped role_tbl">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
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

<!-- /.content-wrapper -->






@endsection('content')
@section('scripts')
@include('admin.layouts.dataTableScripts')
<script>
  
        var table = "";

        $(function() {

            table = $('.role_tbl').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: true,
                autoWidth: false,
                "iDisplayLength" : 10,
                ajax: "{{ route('roles.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
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
                    
                ],
            });
        });

</script>
@endsection

<!-- /.content-wrapper -->