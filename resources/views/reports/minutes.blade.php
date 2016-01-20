@extends('index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <!-- BEGIN Portlet PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="glyphicon glyphicon-calendar"></i>
                            <span class="caption-subject text-uppercase"> LCCB Meeting Minutes</span>
                            <span class="caption-helper"></span>
                        </div>
                        <div class="actions">
                            <div id="reportrange" class="btn default">
                                <i class="fa fa-calendar"></i> &nbsp; <span></span> <b class="fa fa-angle-down"></b>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Portlet PORTLET-->
            </div>
        </div>
        <div id="loadingBlock">
            <div class="row" id="newRequestBlock">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>New Requests</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 report-block" id="newReport">

                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="newApprovalsBlock">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Approvals</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 report-block" id="newApprovals">

                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="actionItemsBlock">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Open Action Items</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 report-block" id="actionItems">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script id="newTemplate" type="text/x-handlebars-template">
        <div class="row request-item">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-2 request-inside">
                        <b>ID</b><br><a href="/lccb/@{{ id }}/edit">@{{ id }}</a>
                    </div>
                    <div class="col-xs-2 request-inside">
                        <b>Category</b><br>@{{ category }}
                    </div>
                    <div class="col-xs-2 request-inside">
                        <b>Equipment</b><br>@{{ equipment }}
                    </div>
                    <div class="col-xs-3 request-inside">
                        <b>Requester</b><br>@{{ requester }}
                    </div>
                    <div class="col-xs-3 request-inside">
                        <b>Status</b><br>@{{ status }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 request-inside">
                        <b>Description</b><br>@{{description}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 request-inside">
                        <b>Comments</b><br>
                        <ul>
                            @{{#each comments}}
                            <li>@{{ comment }}</li>@{{/each}}
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </script>

    <script id="approvalsTemplate" type="text/x-handlebars-template">
        <div class="row request-item">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-3 request-inside">
                        <b>Approver</b><br>@{{ approver }}
                    </div>
                    <div class="col-xs-3 request-inside">
                        <b>Decision</b><br>@{{ choice }}
                    </div>
                    <div class="col-xs-3 request-inside">
                        <b>Decision Made On</b><br>@{{ created_at }}
                    </div>
                    <div class="col-xs-3 request-inside">
                        <b>Request ID</b><br><a href="/lccb/@{{ id }}/edit">@{{ id }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 request-inside">
                        <b>Request Description</b><br>@{{description}}
                    </div>
                </div>

            </div>
        </div>
    </script>

    <script id="actionItemsTemplate" type="text/x-handlebars-template">
        <div class="row request-item">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-3 request-inside">
                        <b>Submitted By</b><br>@{{ submitter }}
                    </div>
                    <div class="col-xs-3 request-inside">
                        <b>Date Submitted</b><br>@{{ created_at }}
                    </div>
                    <div class="col-xs-3 request-inside">
                        <b>Due By</b><br>@{{ due_on }}
                    </div>
                    <div class="col-xs-3 request-inside">
                        <b>Request</b><br><a class="btn btn-xs btn-default" href="/lccb/@{{ r_id }}/edit">View</a> <button disabled data-a_id="@{{ a_id }}" class="btn btn-xs btn-primary">Close</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 request-inside">
                        <b>Action Item</b><br>@{{action_item}}
                    </div>
                </div>

            </div>
        </div>
    </script>
@endsection


@section('js')
    <script src="/plugins/moment.min.js"></script>
    <script src="/js/handlebars.min.js"></script>
    <script src="/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/highcharts.js"></script>
    <script src="/js/app/reports/minutes.js"></script>

@endsection
@section('css')
    <link href="/css/daterangepicker-bs3.css" rel="stylesheet">
    <style>
        /***
Bootstrap Daterangepicker
***/
        .modal-open .daterangepicker {
            z-index: 10055 !important;
        }

        .daterangepicker {
            margin-top: 4px;
        }

        .daterangepicker td {
            text-shadow: none;
        }

        .daterangepicker td.active {
            background-color: #4b8df8;
            background-image: none;
            filter: none;
        }

        .daterangepicker th {
            font-weight: 400;
            font-size: 14px;
        }

        .daterangepicker .ranges input[type="text"] {
            width: 70px !important;
            font-size: 11px;
            vertical-align: middle;
        }

        .daterangepicker .ranges label {
            font-weight: 300;
            display: block;
        }

        .daterangepicker .ranges {
            width: 170px;
        }

        .daterangepicker .ranges ul > li.active {
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            -ms-border-radius: 4px;
            -o-border-radius: 4px;
            border-radius: 4px;
        }

        .daterangepicker .ranges .btn {
            margin-top: 10px;
        }

        .daterangepicker.dropdown-menu {
            padding: 5px;
        }

        .daterangepicker .ranges li {
            color: #333;
        }

        .daterangepicker .ranges li.active,
        .daterangepicker .ranges li:hover {
            background: #4b8df8 !important;
            border: 1px solid #4b8df8 !important;
            color: #fff;
        }

        .daterangepicker .range_inputs input {
            margin-bottom: 0 !important;
        }

        .daterangepicker .fa-angle-right:before {
            content: "\f105";
        }

        .daterangepicker .fa-angle-left:before {
            content: "\f104";
        }
    </style>
@endsection