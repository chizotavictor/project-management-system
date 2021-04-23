@extends('layouts.dashboard')
@section('contents')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Task Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home') }}">Home</a></li>
              {{-- <li class="breadcrumb-item active"><a href="{{ route('user.taskitem', ['task_id' => $task->id]) }}">{{$task->id}}</a></li> --}}
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

            <div class="col-md-12">
                <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">From: {{$task->initiator->name}}, {{$task->initiator->email}}
                        <span class="text-muted" style="font-size:12px">{{$task->created_at->format('d M. Y h:i A')}}</span></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="mailbox-read-info">
                        <h6 class="ml-2"><b>{{$task->title}}</b></h6> 
                        @if (isset($task->designator_id))
                            <span  class="ml-2 text-success">Primary: <b>(<span>{{$task->designator->name}},</span> {{$task->designator->email}})</b></span>
                        @endif
                    </div>
                    <!-- /.mailbox-read-info -->
                    <div class="mailbox-controls with-border text-right">
                   
                    <!-- /.btn-group -->
                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message" style="text-align: left">
                        {!! $task->description !!}         
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer bg-white">
                    <div class="row">
                        <h4>Task Items</h4>
                    </div>
                    
                    <div class="col-12">
                        @foreach($task->items as $item)
                        <div class="post">
                            <div class="user-block">
                              <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/avatar.png')}}" alt="user image">
                              <span class="username">
                                <a href="#">{{$item->designator->name}}, {{$item->designator->email}}</a>
                              </span>
                              <span class="description">Shared publicly - {{$item->created_at->format('d M. Y h:i A')}}</span>
                            </div>

                            <h6><b>{{$item->task_indicator}}</b></h6>
                            <!-- /.user-block -->
                            {!! $item->description !!}
                            <p>
                                @if ($item->status== "Completed")
                                    <span class="badge badge-success">Completed</span>
                                @else
                                <span class="badge badge-primary">{{$item->status}}</span>
                                @endif
                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Task Issues</a>
                                @if ($item->status== "Completed")
                                    <form action="{{ route('subtask.start') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="sub_task_id" value="{{$item->id}}">
                                    <button title="Click here to Start Task" class="text-sm"><i class="fa fa-play text-primary"></i> Start Sub Task</button>
                                    </form>
                                @else
                                <button class="text-sm"><i class="fa fa-bell text-success"></i> Notify Admin</button>
                                @endif
                            </p>
                        </div>
                        {{-- <hr> --}}
                        @endforeach
                    </div>
                </div>

                <!-- /.card-footer -->
                <div class="card-footer">
                    <button type="button" class="btn btn-primary"><i class="fas fa-bell"></i> Notify Admin</button>
                    {{-- <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button> --}}
                </div>
                <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
          </div>
        </div>
    </section>
</div>
@endsection