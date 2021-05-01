@extends('layouts.dashboard')
@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Task Item Issue</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('task') }}">Tasks</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('taskitem', $item_id) }}">Task Items</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('issues', $item_id) }}">Issues</a></li>
                            <li class="breadcrumb-item active">Add Issue</li>
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
                                <h3 class="card-title">Add New Issue</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{ route('issue.create')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $item_id }}" name="task_item_id">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name" class="">Comment</label>
                                        <textarea class="textarea @error('comment') is-invalid @enderror" name="comment"
                                                  required autofocus></textarea>
                                        @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
