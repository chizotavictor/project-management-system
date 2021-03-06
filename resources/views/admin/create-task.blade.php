@extends('layouts.dashboard')
@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $task ? 'Edit' : 'Add' }} Task</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('task') }}">Tasks</a></li>
                            <li class="breadcrumb-item active">Add Task</li>
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
                                <h3 class="card-title">{{ $task ? 'Edit' : 'Add New' }} Task</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{ $task ? route('task.update') : route('task.add.submit')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $task ? $task->id : '' }}" name="id">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name" class="">Title</label>
                                        <textarea class="form-control @error('title') is-invalid @enderror"
                                                  name="title" required autofocus>{{ $task ? $task->title : old('title') }}</textarea>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="">Description</label>
                                        <textarea class="textarea @error('description') is-invalid @enderror"
                                                  name="description" required autofocus>
                                    {{ $task ? $task->description : old('description') }}
                                </textarea>
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
                                                @if ($task && $s->id == $task->designator_id)
                                                    <option selected value="{{$s->id}}">{{$s->name}}</option>
                                                @else
                                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <div class="input-group date" id="start_date" data-target-input="nearest">
                                            <input type="text" name="start_date" required class="form-control datetimepicker-input"
                                                   data-target="#start_date" value="{{ $task ? $task->start_date : '' }}"/>
                                            <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>End Date:</label>
                                        <div class="input-group date" id="delivery_date" data-target-input="nearest">
                                            <input type="text" name="delivery_date" required class="form-control datetimepicker-input"
                                                   data-target="#delivery_date" value="{{ $task ? $task->delivery_date : '' }}"/>
                                            <div class="input-group-append" data-target="#delivery_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('delivery_date')
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
