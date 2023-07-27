@extends('admin.layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <!-- <a class="btn-sm btn-success" href="{{ route('roles.index') }}"> <i class="fa fa-arrow-left" aria-hidden="true"></i></a> -->
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <a class="btn-sm btn-success" href="{{ route('users.index') }}"> <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <!-- <h1>Show Role</h1> -->
        <div class="pull-right">
        </div>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">View {{$page_name}}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>


<!-- Content Header (Page header) -->
<section class="content-header">
  <!-- <a class="btn-sm btn-success" href="{{ route('roles.index') }}"> <i class="fa fa-arrow-left" aria-hidden="true"></i></a> -->
  <div class="container-fluid">
  <div class="card card-primary">
<div class="card-header">
<h3 class="card-title">About {{$page_name}}</h3>
</div>

<div class="card-body">
<strong><i class="fa fa-list-alt mr-1"></i> Name</strong>
<p class="text-muted">
{{ $category->name }}
</p>
<hr>
<strong><i class="far fa-calendar mr-1"></i> Status</strong>
<p class="text-muted">
@if ($category->status)
<label class="badge badge-success">Activated</label>
@else
<label class="badge badge-danger">Dectivated</label>
@endif

</p>
</div>
  </div><!-- /.container-fluid -->
</section>


@endsection


