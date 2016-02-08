@extends('index')

@section('content')

    <div class="container" id="container" data-request_id="{!! $request->id !!}">

        <div class="row">
            <div class="col-xs-6">
                <h2>Edit LCCB Request #{!! $request->id !!}</h2>
            </div>
            <div class="col-xs-6">
                <h2 class="pull-right">Submitted by: {!! $request->Requester->name !!}</h2>
            </div>
        </div>

        @if($request->submitted_by == Auth::User()->id && (Auth::User()->hasRole('administrator') || Auth::User()->hasRole('approver')))
            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        You cannot change the status for requests that you have submitted.
                    </div>
                </div>
            </div>
        @endif

        @if($request->submitted_by == Auth::User()->id || (Auth::User()->hasRole('administrator') || Auth::User()->hasRole('approver')))
            <hr>
            <div class="row">
                <div class="col-xs-9">
                    @if($request->Status->name != 'Approved')
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#comment-modal" id="comment-request">Comment</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#action-item-modal" id="action-item-request">Add Action Item</button>
                            @if($request->submitted_by == Auth::User()->id)

                            @else
                                @if(!$request->field_walk)
                                    </div>
                                    <a href="/request/{{ $request->id }}/field-walk" type="button" class="btn btn-success" id="field_walk">
                                        Field Walk Has Been Verified to be Completed
                                    </a>
                                    <div class="btn-group" role="group">
                                @else
                                    @if(!$hasApproved)
                                        <button type="button" class="btn btn-success" id="approve-request" data-toggle="modal" data-target="#approver-modal" data-token="{{ csrf_token() }}">
                                            Approve
                                        </button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#reject-modal" data-token="{{ csrf_token() }}" id="reject-request">Reject</button>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Set Status <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a class="update-status" data-token="{{ csrf_token() }}" data-status="new" data-request_id="{!! $request->id !!}" href="#">New</a>
                                                </li>
                                                <li>
                                                    <a class="update-status" data-token="{{ csrf_token() }}" data-status="open-needs-further-review" data-request_id="{!! $request->id !!}" href="#">Needs Further Review</a>
                                                </li>
                                                <li>
                                                    <a class="delete-request" data-token="{{ csrf_token() }}" data-request_id="{!! $request->id !!}" href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>

                                    @else
                                        <button type="button" class="btn btn-info" id="revoke-request" data-request_id="{!! $request->id !!}" data-token="{{ csrf_token() }}">
                                            Revoke Approval
                                        </button>
                                    @endif
                                @endif

                            @endif
                            <button type="button" class="btn btn-info" id="submitForm">Update Request</button>
                        </div>
                    @else
                        <h4>This request has been approved and locked</h4>
                    @endif
                </div>
                <div class="col-xs-3 text-middle">
                    <h4 class="pull-right">
                        <span class="label label-primary" id="request-status">{!! $request->Status->name !!}</span></h4>
                </div>
            </div>
            <hr>
        @endif

        <div class="row" id="error" style="display: none;">
            <div class="col-xs-12">
                <div class="bs-component">
                    <div class="alert alert-dismissible alert-danger text-center">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <h4><strong>Oh snap!</strong> There were some errors on the form, let's try again!</h4>
                    </div>
                    <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#edit" aria-controls="home" role="tab" data-toggle="tab">Edit Request</a></li>
                    <li role="presentation">
                        <a href="#action-items" aria-controls="action-items" role="tab" data-toggle="tab">Action Items</a>
                    </li>
                    <li role="presentation">
                        <a href="#comments" aria-controls="profile" role="tab" data-toggle="tab">Comments</a></li>
                    <li role="presentation">
                        <a href="#files" aria-controls="messages" role="tab" data-toggle="tab">Files</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active spacer" id="edit">
                        {!! Form::model($request, array('url' => array('/lccb/update', $request->id), 'files' => 'true', 'id' => 'edit-request-form')) !!}
                        @include('request._edit-form')
                        {!! Form::close() !!}
                    </div>
                    <div role="tabpanel" class="tab-pane spacer" id="action-items">
                        @include('request._action-items')
                    </div>
                    <div role="tabpanel" class="tab-pane spacer" id="comments">
                        @include('request._edit-comments')
                    </div>
                    <div role="tabpanel" class="tab-pane spacer" id="files">
                        @include('request._edit-uploads')
                    </div>
                </div>


            </div>
        </div>

        <!-- Approving Modal -->
        <div class="modal modal-wide fade" id="approver-modal" tabindex="-1" role="dialog" aria-labelledby="approver-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Request Approval</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4>Current Approvals</h4>
                            </div>
                        </div>

                        @if(sizeof($approvers) > 0)
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>
                                                Name
                                            </th>
                                            <th>
                                                Organization
                                            </th>
                                            <th>
                                                Decision
                                            </th>
                                            <th>
                                                Offline
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Comments
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($approvers as $approver)
                                            <tr>
                                                <td>
                                                    {!! $approver->name !!}
                                                </td>
                                                <td>
                                                    {!! $approver->org !!}
                                                </td>
                                                <td>
                                                    {!! $approver->choice !!}
                                                </td>
                                                <td>
                                                    {!! $approver->approved_offline !!}
                                                </td>
                                                <td>
                                                    {!! $approver->updated_at !!}
                                                </td>
                                                <td>
                                                    {!! $approver->comment !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-xs-4">
                                    None
                                </div>
                            </div>
                        @endif
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input id="approved-offline" name="approved-offline" type="checkbox" value="0"> Approved Offline?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="comment">Comments?</label>
                                    <textarea name="comment" rows="5" cols="20" id="comment" class="form-control" placeholder="Anything you would like to say?"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="run-approval" data-id="{!! $request->id !!}" data-token="{{ csrf_token() }}">Approve Request</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejecting Modal -->
        <div class="modal modal fade" id="reject-modal" tabindex="-1" role="dialog" aria-labelledby="reject-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Request Rejection</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input id="rejected-offline" name="rejected-offline" type="checkbox" value="0"> Approved Offline?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="comment">Comments?</label>
                                    <textarea name="comment" rows="5" cols="20" id="reject-comment" class="form-control" placeholder="Why are you rejecting this?"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="run-rejection" data-id="{!! $request->id !!}" data-token="{{ csrf_token() }}">Reject Request</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comment Modal -->
        <div class="modal modal-wide fade" id="comment-modal" tabindex="-1" role="dialog" aria-labelledby="comment-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="commentModalLabel">Request Comment</h3>
                    </div>{!! Form::open(array('url' => array('comment'), 'id' => 'new-comment-form'))!!}
                    <input type="hidden" name="request_id" value="{!! $request->id !!}">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="requested_on">Speak Your Mind</label>
                                    <textarea name="comment" class="form-control" rows="3" placeholder="What do you have to say?"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="run-approval" data-id="{!! $request->id !!}" data-token="{{ csrf_token() }}">Add Comment</button>
                    </div>{!! Form::close() !!}
                </div>
            </div>
        </div>

        <!-- Action Item Modal -->
        <div class="modal modal-wide fade" id="action-item-modal" tabindex="-1" role="dialog" aria-labelledby="action-item-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="commentModalLabel">New Action Item</h3>
                    </div>
                    {!! Form::open(array('url' => array('action'), 'id' => 'new-action-form'))!!}
                    <input type="hidden" name="request_id" value="{!! $request->id !!}">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label class="control-label" for="due_on">Due Date</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="due_on" name="due_on">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-th"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="action">Action Item</label>
                                    <textarea name="action" id="action" class="form-control" rows="3" placeholder="Delegation is amazing am I right?"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="run-approval" data-id="{!! $request->id !!}" data-token="{{ csrf_token() }}">Add Action</button>
                    </div>{!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>





@endsection

@section('js')
    <script src="/js/jquery.form.js"></script>
    <script src="/plugins/serialize.js"></script>
    <script src="/plugins/moment.js"></script>
    <script src="/plugins/shadow/jquery.colorbox-min.js"></script>
    <script src="/plugins/typeahead.bundle.min.js"></script>
    <script src="/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="/plugins/dropzone/dropzone.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/handlebars.min.js"></script>
    <script src="/js/app/edit_request.js"></script>
@endsection

@section('css')
    <link href="/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="/css/colorbox.css" rel="stylesheet">
    <link href="/plugins/dropzone/dropzone.css" rel="stylesheet">
    <style>
        .iframe-container {
            padding-bottom: 60%;
            padding-top: 30px;
            height: 0;
            overflow: hidden;
        }

        .iframe-container iframe,
        .iframe-container object,
        .iframe-container embed {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection