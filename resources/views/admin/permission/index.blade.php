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

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card">
        <div class="card-header">
      <h3 class="card-title">Create New {{$page_name}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::open(array('route' => 'permission.store','method'=>'POST')) !!}
    <div class="card-body">
    <div class="col-xs-12 col-sm-12 col-md-12">
      @if (count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
        <div class="form-group">
            <strong>Name </strong>
            <input placeholder="Name" required class="form-control" name="name" type="text">
        </div>
    </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    {!! Form::close() !!}
  </div>
  <!-- /.card -->
</div>
<!-- Main content -->
<section class="content">
  <div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">{{$page_name}} List</h3>

   
</div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped permission_tbl">
        <thead>
          <tr>
            <th>No</th>
            <th>Name </th>
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

            table = $('.permission_tbl').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: true,
                autoWidth: false,
                "iDisplayLength" : 10,
                ajax: "{{ route('permission.index') }}",
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

