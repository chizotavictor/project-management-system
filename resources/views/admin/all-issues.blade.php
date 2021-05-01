@extends('layouts.dashboard')
@section('contents')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="d-flex">
                        <h1>All Task Item Issues</h1>
                        <a class="btn btn-primary ml-3" href="{{ route('issue.add', $item_id) }}">
                            Add New Issue
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('task') }}">Tasks</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('taskitem', $item_id) }}">Task Items</a></li>
                        <li class="breadcrumb-item active">All Issues</li>
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
        </div>
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Issue Board</h3>
                    </div>

                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-12">
                                @foreach($issues as $issue)
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/avatar.png')}}"
                                                 alt="user image">
                                            <span class="username">
                                                <a href="#">
                                                    {{$issue->taskItem->designator->name}}, {{$issue->taskItem->designator->email}}
                                                </a>
                                            </span>
                                            <span class="description font-weight-normal">
                                                Shared publicly - {{$issue->created_at->format('d M. Y h:i A')}}
                                            </span>
                                            {!! $issue->comment !!}
                                        </div>
                                        @if($issue->status == 'Open')
                                            <div>
                                                <a href="#"
                                                   class="link-black text-sm ml-3">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </a>
                                                <a href="#" class="link-black text-sm ml-3"
                                                   data-toggle="modal" data-target="#modalDeleteTaskItemIssue{{ $issue->id }}">
                                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                                </a>
                                                <a href="#" class="link-black text-sm ml-3"
                                                   data-toggle="modal" data-target="#modalCloseIssue{{ $issue->id }}">
                                                    <i class="fas fa-times mr-1"></i> Close
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>
@endsection
