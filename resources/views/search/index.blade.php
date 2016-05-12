@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h3>
                    Search
                </h3>
                <table class="table table-responsive" id="search">
                    <thead>
                    <tr>
                        <th width="5%">
                            ID
                        </th>
                        <th>
                            Requested On
                        </th>
                        <th>
                            Request By
                        </th>
                        <th>
                            Equipment
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            Area
                        </th>
                        <th>
                            Location
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Organization
                        </th>
                        <th>
                            Status
                        </th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>

                        </th>
                        <th>

                        </th>
                        <th>

                        </th>
                        <th>

                        </th>
                        <th>

                        </th>
                        <th>

                        </th>
                        <th>

                        </th>
                        <th>

                        </th>
                        <th>

                        </th>
                    </tr>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <!--
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.0/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.0/js/buttons.flash.min.js"></script>
    -->
    <script src="/plugins/moment.min.js"></script>
    {{--<script src="/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>--}}


    <script type="text/javascript" src="https://cdn.datatables.net/r/bs/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.8,b-1.0.0,b-flash-1.0.0,b-html5-1.0.0,b-print-1.0.0/datatables.min.js"></script>
    <script src="/js/app/search.js"></script>

@endsection

@section('css')
    <!--
    <link href="/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.0.0/css/buttons.bootstrap.min.css" rel="stylesheet">
    -->
    {{--<link href="/css/daterangepicker-bs3.css" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.8,b-1.0.0,b-flash-1.0.0,b-html5-1.0.0,b-print-1.0.0/datatables.min.css"/>
@endsection