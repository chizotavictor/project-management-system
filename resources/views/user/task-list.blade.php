@extends('layouts.dashboard')
@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assigned Tasks</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tasks</li>
                            <li class="breadcrumb-item active">Assigned Tasks</li>
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
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Task Board</h3>

                                <div class="card-tools">
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
                                                <td class="mailbox-star">
                                                    @if ($t->status == \App\Http\Constants\Index::COMPLETED)
                                                        <span class="badge badge-success">Completed</span>
                                                    @elseif($t->status == \App\Http\Constants\Index::IN_PROGRESS)
                                                        <span class="badge badge-primary">In Progress</span>
                                                    @elseif($t->status == \App\Http\Constants\Index::SUBMITTED)
                                                        <span class="badge badge-info">Submitted</span>
                                                    @elseif($t->status == \App\Http\Constants\Index::PENDING)
                                                        <span class="badge badge-warning">
                                                            {{ str_replace('-', ' ', $t->status) }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                             {{ str_replace('-', ' ', $t->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="mailbox-name">
                                                    <a href="{{ $t->status == \App\Http\Constants\Index::IN_ACTIVE ? '#'
                                                        : route('user.taskitem', ['task_id' => $t->id]) }}">
                                                        <b>{{$t->title}}</b>
                                                    </a>
                                                    <br>  <span>({{sizeof($t->items)}}) task items</span>
                                                </td>
                                                <td class="mailbox-subject">
                                                    <b>{{\App\Http\Constants\Index::fdt($t->start_date)}}</b> -
                                                    <b>{{\App\Http\Constants\Index::fdt($t->delivery_date)}}</b>
                                                </td>
                                                <td class="mailbox-attachment"></td>
                                                <td class="mailbox-date">
                                                    {{$t->created_at->diffForHumans()}} <br>
                                                    <small>{{$t->created_at->format('d M, Y h:i A')}}</small>
                                                </td>
                                                <td>
                                                   
                                                    @if($t->status == \App\Http\Constants\Index::IN_ACTIVE &&
                                                        $t->status == \App\Http\Constants\Index::IN_PROGRESS)
                                                        <div class="icheck-primary">
                                                            <form action="{{ route('task.start') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="task_id" value="{{$t->id}}">
                                                                <button title="Click here to Start Task">
                                                                    <i class="fa fa-play text-primary"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer p-0">
                                <div class="mailbox-controls">
                                    {{$ts->links()}}
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
@endsection
