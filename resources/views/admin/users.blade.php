@extends('index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3>Users</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table" id="users-table">
                    <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Organization
                        </th>
                        <th>
                            Role
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src="/js/app/users.js"></script>
@endsection

@section('css')
    <link href="/css/dataTables.bootstrap.css" rel="stylesheet">
@endsection