@extends('index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h3>Organizations</h3>
            </div>
            <div class="col-xs-6">
                <button class="add-new-vendor btn btn-default pull-right">+ Add</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table" id="vendors-table">
                    <thead>
                    <tr>
                        <th width="90%">
                            Name
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add-new-vendor-modal" tabindex="-1" role="dialog" aria-labelledby="add-new-vendor-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form action="" id="add-org-form" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" id="method" name="_method" value="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Organization</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row" id="error-message-div" style="display: none">
                            <div class="col-xs-12">
                                <div class="alert alert-danger" id="error-message">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="name">Organization Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-button">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src="/js/app/vendors_index.js"></script>
@endsection

@section('css')
    <link href="/css/dataTables.bootstrap.css" rel="stylesheet">
@endsection