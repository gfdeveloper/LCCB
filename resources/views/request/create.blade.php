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
                <h3>New LCCB Request</h3>
            </div>
        </div>

        {!! Form::open(array('url' => array('lccb'), 'files' => 'true', 'id' => 'new-request-form'))!!}
        @include('request._form')
        {!! Form::close() !!}

    </div>
@endsection

@section('js')
    <script src="/js/jquery.form.js"></script>
    <script src="/plugins/serialize.js"></script>
    <script src="/plugins/moment.js"></script>
    <script src="/plugins/typeahead.bundle.min.js"></script>
    <script src="/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="/plugins/dropzone/dropzone.js"></script>
    <script src="/js/app/request.js"></script>
@endsection

@section('css')
    <link href="/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/plugins/dropzone/dropzone.css" rel="stylesheet">
@endsection