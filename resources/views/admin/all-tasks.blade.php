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
                        <h1>All Tasks</h1>
                        <a class="btn btn-primary ml-3" href="{{ route('task.add') }}">
                            Add New Task
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">All Tasks</li>
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
                        <h3 class="card-title">Task Board</h3>

                        <div class="card-tools">
                        {{-- <div class="input-group input-group-sm">
                          <input type="text" class="form-control" placeholder="Search Mail">
                          <div class="input-group-append">
                            <div class="btn btn-primary">
                              <i class="fas fa-search"></i>
                            </div>
                          </div>
                        </div> --}}
                        </div>
                        <!-- /.card-tools -->
                    </div>
                     <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="mailbox-controls">
                        {{$ts->links()}}
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                                @foreach ($ts as $t)
                                <tr>
                                    <td>
                                        @if($t->status !== 'In-active')
                                            <div class="icheck-primary">
                                                <a href="{{ route('task.edit', ['task_id' => $t->id]) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{route('taskitem.add', ['task_id' => $t->id])}}">
                                                    <i class="fa fa-plus text-success"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="mailbox-star">
                                        @if ($t->status=="Completed")
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($t->status=="In-Progress")
                                            <span class="badge badge-primary">In Progress</span>
                                        @elseif($t->status=="Submitted")
                                            <span class="badge badge-primary">Submitted</span>
                                        @else
                                            <span class="badge badge-danger">{{$t->status}}</span>
                                        @endif
                                    </td>
                                    <td class="mailbox-name">
                                        <a href="{{ route('taskitem', ['task_id' => $t->id]) }}"><b>{{$t->title}}</b></a>
                                    </td>
                                    <td class="mailbox-subject">
                                        <b>{{Carbon\Carbon::parse(strtotime($t->start_date))->format('d M, Y')}}</b> -
                                        <b>{{Carbon\Carbon::parse(strtotime($t->delivery_date))->format('d M, Y') }}</b>
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date">
                                        {{$t->created_at->diffForHumans()}} <br>
                                        <small>{{$t->created_at->format('d M, Y h:i A')}}</small>
                                    </td>
                                    <td>
                                        @if($t->status !== 'In-active')
                                            <div class="icheck-primary">
                                                <a href="#" data-toggle="modal" data-target="#modalDeleteTask{{ $t->id }}">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                            </div>
                                            @include('partials.modals.delete-task-modal', [
                                                'modalId' => 'modalDeleteTask' . $t->id, 'id' => $t->id
                                            ])
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer p-0">
                    <div class="mailbox-controls">
                        {{$ts->links()}}
                    </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
        </div>
    </section>
</div>
@endsection
