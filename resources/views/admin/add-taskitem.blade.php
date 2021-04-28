@extends('layouts.dashboard')
@section('contents')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $item ? $item->task->title : $task->title }}</h1>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('home') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('task') }}">Tasks</a></li>
                  <li class="breadcrumb-item">
                      <a href="{{ route('taskitem', ['task_id' => $item ? $item->task_id : $task->id]) }}">Task Detail</a>
                  </li>
                  <li class="breadcrumb-item active">{{ $item ? 'Edit' : 'Add' }} Task Item</li>
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
                  <h3 class="card-title">{{ $item ? 'Edit' : 'Add New' }} Task Item</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ $item ? route('taskitem.update') : route('taskitem.add.submit', ['task_id' => $task->id])}}"
                      role="form" method="POST">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="">Task Indicator</label>
                        <textarea class="form-control @error('task_indicator') is-invalid @enderror" name="task_indicator"
                                  required autofocus>{{ $item ? $item->task_indicator : old('task_indicator') }}</textarea>
                        @error('task_indicator')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="">Description</label>
                        <textarea class="textarea @error('description') is-invalid @enderror" name="description"
                                  required autofocus>{{ $item ? $item->description : old('description') }}</textarea>
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
                              @if ($item && $s->id == $item->designator_id)
                                  <option selected value="{{$s->id}}">{{$s->name}}</option>
                              @else
                                  <option value="{{$s->id}}">{{$s->name}}</option>
                              @endif
                          @endforeach
                      </select>
                    </div>
                      <input type="hidden" name="task_id" value="{{ $item ? $item->task_id : $task->id }}">
                      <input type="hidden" name="id" value="{{ $item ? $item->id : ''}}">

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
