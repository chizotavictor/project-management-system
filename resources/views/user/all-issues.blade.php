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
                        <h1>All Issues</h1>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item">All Issues</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

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
                        <h3 class="card-title">Issues Board</h3>
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
                                        @if($issue->status == \App\Http\Constants\Index::OPEN)
                                            <div>
                                                <a href="#" class="link-black text-sm ml-3"
                                                   data-toggle="modal" data-target="#modalMarkAsDone{{ $issue->id }}">
                                                    <i class="fas fa-check mr-1"></i> Mark as done
                                                </a>
                                            </div>
                                            @include('partials.modals.mark-as-done-modal', [
                                                 'modalId' => 'modalMarkAsDone' . $issue->id, 'id' => $issue->id
                                             ])
                                        @elseif($issue->status == \App\Http\Constants\Index::IN_REVIEW)
                                            <span class="badge badge-info">{{ $issue->status }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $issue->status }}</span>
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
