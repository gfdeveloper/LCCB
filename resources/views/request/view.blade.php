@extends('index')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-xs-6">
                <h2>View LCCB Request #{!! $request->id !!}</h2>
            </div>
            <div class="col-xs-6">
                <h2 class="pull-right">Submitted by: {!! $request->Requester->name !!}</h2>
            </div>
        </div>


        @if(Auth::User()->hasRole('administrator'))
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    @if($request->Status->name != 'Approved')
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary" id="comment-request">Comment</button>
                            <button type="button" class="btn btn-success" id="approve-request" data-toggle="modal" data-target="#approver-modal">Approve</button>
                            <button type="button" class="btn btn-danger" id="reject-request">Reject</button>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    Set Status <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Needs Further Review</a></li>
                                    <li><a class="delete-request" href="#">Delete</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-primary" id="layout_complete_button">Layout has been updated!</button>
                        </div>
                    @else
                        <h4>This request has been approved and locked</h4>
                    @endif
                </div>
                <div class="col-xs-6 text-middle">
                    <h4 class="pull-right">
                        <span class="label label-primary" id="request-status">{!! $request->Status->name !!}</span></h4>
                </div>
            </div>
            <hr>
        @endif

        @if(Auth::User()->hasRole('layout_team'))
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary" id="layout_complete_button">Layout has been updated!</button>
                    </div>
                    <div class="col-xs-6 text-middle">
                        <h4 class="pull-right">
                            <span class="label label-primary" id="request-status">{!! $request->Status->name !!}</span></h4>
                    </div>
                </div>
            </div>
        @endif

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#view" aria-controls="home" role="tab" data-toggle="tab">Request</a></li>
            <li role="presentation">
                <a href="#files" aria-controls="files" role="tab" data-toggle="tab">Files</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="view">
                @include('request._view-request')
            </div>
            <div role="tabpanel" class="tab-pane" id="files">
                @include('request._edit-uploads')
            </div>
        </div>


    </div>



@endsection

@section('js')

@endsection

@section('css')

@endsection