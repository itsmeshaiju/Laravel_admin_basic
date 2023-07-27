@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <!-- <a class="btn-sm btn-success" href="{{ route('roles.index') }}"> <i class="fa fa-arrow-left" aria-hidden="true"></i></a> -->
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <a class="btn-sm btn-success" href="{{ route('roles.index') }}"> <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <!-- <h1>Show Role</h1> -->
        <div class="pull-right">
        </div>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Create New {{$page_name}}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="card-header">
      <h3 class="card-title">Create New {{$page_name}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
    <div class="card-body">
      <div class="form-group">
        <label for="exampleInputEmail1"></label>
        <input type="text" class="form-control" name="name" placeholder="Enter name">
      </div>
      <strong>Permissions</strong>
      <div class="col-md-12 row">
      
      @foreach($permission as $value)
      <div class="col-md-3">
      <div class="form-check">
        <label class="form-check-label">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
          {{ $value->name }}</label>
      </div>
      </div>
      @endforeach
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
@endsection