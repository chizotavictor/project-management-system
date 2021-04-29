@extends('layouts.dashboard')
@section('contents')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $user ? 'Edit' : 'Add' }} User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('staff') }}">Users</a></li>
              <li class="breadcrumb-item active">{{ $user ? 'Edit' : 'Add' }} User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if(Session::has('error'))
                    <div class="col-md-12">
                    <div class="alert alert-danger">
                        {{ Session::get('error')}}
                    </div>
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ Session::get('success')}}
                    </div>
                    </div>
                @endif
            </div>
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{ $user ? 'Edit' : 'Add New' }} User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{$user ? route('staff.update') : route('staff.add.submit')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user ? $user->id : '' }}">
                  <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                               value="{{ $user ? $user->name : old('name') }}" required autocomplete="name" placeholder="Enter name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                             value="{{ $user ? $user->email: old('email') }}" required id="email" placeholder="Enter email">
                      @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                     @enderror
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Password Confirmation</label>
                        <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                               name="phone_number" id="phone_number" required placeholder="Phone number"
                               value="{{ $user ? $user->phone_number : old('phone_number') }}">
                        @error('phone_number')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="github_link">Github Link</label>
                        <input type="text" class="form-control @error('github_link') is-invalid @enderror" name="github_link"
                               id="github_link" placeholder="Github Link (Optional)"
                               value="{{ $user ? $user->github_link : old('github_link') }}">
                        @error('github_link')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="github_link">User Type</label>
                        <select name="is_admin" required class="form-control">
                            <option value=""></option>
                            @if($user && $user->is_admin == 0)
                                <option selected value="0">User</option>
                            @elseif($user && $user->is_admin == 1)
                                <option selected value="1">Admin</option>
                            @endif
                            <option value="0">User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
    </section>
@endsection
