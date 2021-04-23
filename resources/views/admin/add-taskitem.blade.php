@extends('layouts.dashboard')
@section('contents')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $task->title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('task') }}">Tasks</a></li>
              <li class="breadcrumb-item"><a href="{{ route('taskitem', ['task_id' => $task->id]) }}">{{$task->id}}</a></li>
              <li class="breadcrumb-item active">Add Task Item</li>
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
                  <h3 class="card-title">Add New Task Item</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('taskitem.add.submit', ['task_id' => $task->id])}}" method="POST">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="">Task Indicator</label>
                        <textarea class="form-control @error('task_indicator') is-invalid @enderror" name="task_indicator" required autofocus>{{ old('task_indicator') }}</textarea>
                        @error('task_indicator')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="">Description</label>
                        <textarea class="textarea @error('description') is-invalid @enderror" name="description" required autofocus>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label for="Designator">Designator</label>
                      <select name="designator_id" required class="form-control">
                          <option value=""></option>
                          @foreach ($staff as $s)
                              <option value="{{$s->id}}">{{$s->name}}</option>
                          @endforeach
                      </select>
                    </div>
                    <input type="hidden" name="task_id" value="{{$task->id}}">
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