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
                        <li class="breadcrumb-item"><a href="{{route('task') }}">Tasks</a></li>
                        <li class="breadcrumb-item active">Task Detail</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                From: {{$task->initiator->name}}, {{$task->initiator->email}}
                                <span class="text-muted" style="font-size:12px">{{$task->created_at->format('d M. Y h:i A')}}</span>
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="mailbox-read-info">
                                <h6 class="ml-2"><b>{{$task->title}}</b></h6>
                                @if (isset($task->designator_id))
                                    <span  class="ml-2 text-success">
                                        Primary: <b>(<span>{{$task->designator->name}},</span> {{$task->designator->email}})</b>
                                    </span>
                                @endif
                            </div>
                            <!-- /.mailbox-read-info -->
                            <div class="mailbox-controls with-border text-right"></div>
                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message pl-3" style="text-align: left">
                                {!! $task->description !!}
                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-white">
                            <div class="row">
                                <h4>Task Items</h4>
                                <div class="btn-group" style="margin-left: 20px;">
                                    <a href="{{route('taskitem.add', ['task_id' => $task->id])}}"
                                       class="btn btn-default btn-sm"><i class="fas fa-plus"></i>
                                    </a>
                                </div>

                                <div class="col-12">
                                @foreach($task->items as $item)
                                     <div class="post">
                                         <div class="user-block">
                                             <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/avatar.png')}}"
                                                  alt="user image">
                                             <span class="username">
                                                 <a href="#">{{$item->designator->name}}, {{$item->designator->email}}</a>
                                             </span>
                                             <span class="description">
                                                 Shared publicly - {{$item->created_at->format('d M. Y h:i A')}}
                                             </span>
                                         </div>

                                         <h6><b>{{$item->task_indicator}}</b></h6>
                                            <!-- /.user-block -->
                                         {!! $item->description !!}
                                         @if($item->status !== 'In-active')
                                             <div>
                                                @if ($item->status == \App\Http\Constants\Index::COMPLETED)
                                                <span class="badge badge-success">Completed</span>
                                            @elseif ($item->status == \App\Http\Constants\Index::IN_PROGRESS)
                                                <span class="badge badge-primary">In Progress</span>
                                                @elseif ($item->status == \App\Http\Constants\Index::SUBMITTED)
                                                <span class="badge badge-primary">Submitted</span>
                                            @elseif($item->status == \App\Http\Constants\Index::IN_ACTIVE)
                                                <span class="badge badge-danger">
                                                    {{ str_replace('-', ' ', $item->status) }}
                                                </span>
                                            @elseif($item->status == \App\Http\Constants\Index::PENDING)
                                                <span class="badge badge-warning">
                                                    {{ str_replace('-', ' ', $item->status) }}
                                                </span>
                                            @endif
                                                 <a href="{{ route('issues', ['item_id' => $item->id, 'task_id' => $item->task_id]) }}"
                                                    class="link-black text-sm">
                                                     <i class="fas fa-link mr-1"></i> Task Issues ({{sizeof($item->issues)}})
                                                 </a>
                                                 <a href="{{ route('taskitem.edit', ['task_id' => $item->task_id, 'item_id' => $item->id]) }}"
                                                    class="link-black text-sm ml-3">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                 </a>
                                                 <a href="#" class="link-black text-sm ml-3"
                                                    data-toggle="modal" data-target="#modalDeleteTaskItem{{ $item->id }}">
                                                     <i class="fas fa-trash-alt mr-1"></i> Delete
                                                 </a>
                                                 @if ($item->status == App\Http\Constants\Index::SUBMITTED)
                                                 <a href="{{route('submit-task-item', ['id' => $item->id, 'status' => App\Http\Constants\Index::COMPLETED])}}" class="link-black text-success text-sm ml-3">
                                                    <i class="fas fa-check mr-1"></i> Approve
                                                </a>
                                                <a href="{{route('submit-task-item', ['id' => $item->id, 'status' => App\Http\Constants\Index::PENDING ])}}" class="link-black text-danger text-sm ml-3">
                                                   <i class="fas fa-times mr-1"></i> Decline
                                                </a>   
                                                 @endif
                                             </div>
                                         @endif
                                     </div>
                                     @include('partials.modals.delete-task-item-modal', [
                                         'modalId' => 'modalDeleteTaskItem' . $item->id, 'id' => $item->id
                                     ])
                                @endforeach
                            </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a class="btn btn-default" href="{{ route('task.edit', ['task_id' => $task->id]) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-default" href="#" data-toggle="modal" data-target="#modalDeleteTask{{ $task->id }}">
                                <i class="far fa-trash-alt"></i> Delete
                            </a>
                            @if ($task->status == App\Http\Constants\Index::SUBMITTED)
                            <a class="btn btn-success" href="{{route('submit-task', ['id' => $item->id, 'status' => App\Http\Constants\Index::COMPLETED])}}">
                                <i class="fas fa-check"></i> Approve
                            </a>
                            <a class="btn btn-danger" href="{{route('submit-task', ['id' => $item->id, 'status' => App\Http\Constants\Index::COMPLETED])}}">
                                <i class="fas fa-times"></i> Decline
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('partials.modals.delete-task-modal', ['modalId' => 'modalDeleteTask' . $task->id, 'id' => $task->id])

@endsection
