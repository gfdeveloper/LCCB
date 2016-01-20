@inject('approval', 'App\Request')
@extends('index')

@section('content')
    <div class="container">
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
                <h2>LCCB Requests</h2>
            </div>
        </div>
        <hr>
        <table class="table table-bordered" id="newRequests">
            <thead>
            <tr>
                <th>
                    Date Submitted
                </th>
                <th>
                    Waiting For
                </th>
                <th>
                    Submitted By
                </th>
                <th>
                    Description
                </th>
                <th>
                    Equipment
                </th>
                <th>
                    Status
                </th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>
                        {!! date("Y-m-d", strtotime($request->requested_on)) !!}
                    </td>
                    <td>
                        {!! $approval->calcDaysOpen($request->requested_on) !!}
                    </td>
                    <td>
                        {!! $request->requester_name !!}
                    </td>
                    <td>
                        {!! str_limit($request->description, 75) !!}
                    </td>
                    <td>
                        {!! $request->Equipment->name !!}
                    </td>
                    <td>
                        {!! $request->Status->name !!}
                    </td>
                    <td>
                        <a type="button" class="btn btn-primary btn-sm" aria-label="Left Align" href="\lccb\{!! $request->id !!}\edit">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit / View
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src="/js/app/newRequests.js"></script>
@endsection

@section('css')
    <link href="/css/dataTables.bootstrap.css" rel="stylesheet">
@endsection