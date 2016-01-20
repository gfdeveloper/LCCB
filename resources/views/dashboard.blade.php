@extends('index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 margin-bottom-30">
                <!-- BEGIN Portlet PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="glyphicon glyphicon-calendar"></i>
                            <span class="caption-subject text-uppercase"> Requests by Organization</span>
                            <span class="caption-helper"></span>
                        </div>
                        <div class="actions">
                            <div id="reportrange" class="btn default">
                                <i class="fa fa-calendar"></i> &nbsp; <span>June 1, 2014 - July 31, 2014</span>
                                <b class="fa fa-angle-down"></b>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body" id="functionalReport" style="height: 400px;">

                    </div>
                </div>
                <!-- END Portlet PORTLET-->
            </div>

            <div class="col-md-4 margin-bottom-30">
                <!-- BEGIN Portlet PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption caption-blue">
                            <i class="glyphicon glyphicon-knight"></i>
                            <span class="caption-subject text-uppercase"> Statistics</span>
                            <span class="caption-helper"></span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body" id="statistics">
                        <div class="row">
                            <div class="col-xs-10">
                                <p class="lead">Total Requests</p>
                            </div>
                            <div class="col-xs-2">
                                <p class="lead" id="total"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10">
                                <li><p class="lead">New</p></li>
                            </div>
                            <div class="col-xs-2">
                                <p class="lead" id="new"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10">
                                <li><p class="lead">Approved</p></li>
                            </div>
                            <div class="col-xs-2">
                                <p class="lead" id="approved"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10">
                                <li><p class="lead">Open / Needs Review</p></li>
                            </div>
                            <div class="col-xs-2">
                                <p class="lead" id="open"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10">
                                <li><p class="lead">Waiting Approval</p></li>
                            </div>
                            <div class="col-xs-2">
                                <p class="lead" id="waiting"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10">
                                <li><p class="lead">Rejected</p></li>
                            </div>
                            <div class="col-xs-2">
                                <p class="lead" id="rejected"></p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- END Portlet PORTLET-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 margin-bottom-30">
                <!-- BEGIN Portlet PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="glyphicon glyphicon-calendar"></i>
                            <span class="caption-subject text-uppercase"> Approvals</span>
                            <span class="caption-helper"></span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body" id="approvalsReport">

                    </div>
                </div>
                <!-- END Portlet PORTLET-->
            </div>
            <div class="col-md-4 margin-bottom-30">
                <!-- BEGIN Portlet PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="glyphicon glyphicon-calendar"></i>
                            <span class="caption-subject text-uppercase"> Average Time to Fully Approve</span>
                            <span class="caption-helper"></span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body" id="averageReport">

                    </div>
                </div>
                <!-- END Portlet PORTLET-->
            </div>
            <div class="col-md-4 margin-bottom-30">
                <!-- BEGIN Portlet PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="glyphicon glyphicon-calendar"></i>
                            <span class="caption-subject text-uppercase"> Open Action Items</span>
                            <span class="caption-helper"></span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body">
                        <h4 id="openActionItems"></h4>
                    </div>
                </div>
                <!-- END Portlet PORTLET-->
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="/plugins/moment.min.js"></script>
    <script src="/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/highcharts.js"></script>
    <script src="/js/app/dashboard.js"></script>

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