@extends('layouts.dashboard')
@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $issue ? 'Edit' : 'Add New' }} Task Item Issue</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('task') }}">Tasks</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{ route('taskitem', $issue ? $issue->taskItem->task_id : $item->task_id) }}">Task Items</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('issues', $issue ?
                                    ['task_id' => $issue->taskItem->id, 'item_id' => $issue->task_item_id] :
                                    ['task_id' => $item->task_id, 'item_id' => $item->id]) }}">Issues</a>
                            </li>
                            <li class="breadcrumb-item active">Issue</li>
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
                                <h3 class="card-title">{{ $issue ? 'Edit' : 'Add New' }} Issue</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{ $issue ? route('issue.update') : route('issue.create')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $issue ? $issue->id : ''}}" name="id">
                                <input type="hidden" value="{{ $issue ? $issue->task_item_id : $item->id }}" name="task_item_id">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name" class="">Comment</label>
                                        <textarea class="textarea @error('comment') is-invalid @enderror" name="comment"
                                                  required autofocus>{{ $issue ? $issue->comment : old('comment') }}</textarea>
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
