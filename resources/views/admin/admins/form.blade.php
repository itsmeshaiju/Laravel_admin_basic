@extends('admin.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title  mb-3">Admin Form</h4>


                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (isset($admin->id))
                        <form action="{{ route('admins.update', $admin->id) }}" enctype="multipart/form-data"
                            class="cmxform" method="POST">
                            @method('PUT')
                        @else
                            <form action="{{ route('admins.store') }}" enctype="multipart/form-data" class="cmxform"
                                method="POST">
                    @endif
                    @csrf

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" class="form-control @error('name') border-danger @enderror" name="name"
                                placeholder="Name" value="{{ old('name', $admin->name ?? null) }}" type="text" required>
                            @error('name')
                                <label class="error mt-1 tx-13 text-danger">{{ $message }}</label>
                            @enderror
                        </div>


                        <div class="col-lg-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" class="form-control @error('email') border-danger @enderror" name="email"
                                placeholder="Email" value="{{ old('email', $admin->email ?? null) }}" type="email"
                                required>
                            @error('email')
                                <label class="error mt-1 tx-13 text-danger">{{ $message }}</label>
                            @enderror
                        </div>


                        <div class="col-lg-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control @error('password') border-danger @enderror"
                                name="password" placeholder="Password" value="{{ old('password', null) }}"
                                type="password">
                            @error('password')
                                <label class="error mt-1 tx-13 text-danger">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input id="confirm_password"
                                class="form-control @error('confirm_password') border-danger @enderror"
                                name="confirm_password" placeholder="Confirm password"
                                value="{{ old('confirm_password', null) }}" type="password">
                            @error('confirm_password')
                                <label class="error mt-1 tx-13 text-danger">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="roles" class="form-label">Role</label>
                            @if (isset($admin->id))
                                {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
                            @else
                                {!! Form::select('roles[]', $roles, [], ['class' => 'form-select', 'multiple']) !!}
                            @endif



                        </div>
                    </div>

                    <input class="btn btn-primary mt-3" type="submit" value="Submit">
                    </form>


                </div>
            </div>
        </div>

    </div>


@endsection
