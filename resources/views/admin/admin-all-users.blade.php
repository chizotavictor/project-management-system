@extends('layouts.dashboard')
@section('contents')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>All Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
              <li class="breadcrumb-item active">All Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">All Users</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="GET" action="">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <input type="text" name="name" placeholder="Search name.." id="" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" name="email" placeholder="Search email.." id="" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" value="Search" class="btn btn-success">Search <i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered">
                            <thead>                  
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone No.</th>
                                <th >User Type</th>
                                <th>Github</th>
                                <th style="width: 20px">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($users as $key => $u)
                              <tr>
                                  <td>{{$key+1}}</td>
                                  <td>{{$u->name}}</td>
                                  <td>{{$u->email}}</td>
                                  <td>{{$u->phone_number}}</td>
                                  <td>
                                    @if ($u->is_admin == "0")
                                        <span class="badge badge-primary">User</span>
                                    @else
                                        <span class="badge badge-success">Admin</span>
                                    @endif
                                  </td>
                                  <td>
                                    @if ($u->github_link == "")
                                        <span class="badge badge-danger">No Link</span>
                                    @else
                                        <a href="{{$u->github_link}}" target="_blank" rel="noopener noreferrer">View Link</a>
                                    @endif
                                  </td>
                                  <td>
                                      <a href="#" title="Edit Record"><i class="fa fa-edit"></i></a>
                                      <a href="#" title="Delete Record"><i class="fa fa-trash"></i></a>
                                  </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        {{$users->links()}}
                    </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
    </section>
@endsection