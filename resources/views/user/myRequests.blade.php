@extends('index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3>My Requests</h3>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Request Date
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Phase
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Equipment
                            </th>
                            <th>
                                Cost
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $request)
                            <tr>
                                <td>
                                    {!! $request['id'] !!}
                                </td>
                                <td>
                                    {!! date("Y-m-d", strtotime($request['requested_on'])) !!}
                                </td>
                                <td>
                                    {!! $request['status']['name'] !!}
                                </td>
                                <td>
                                    {!! $request['location']['name'] !!}
                                </td>
                                <td>
                                    {!! str_limit($request['description'], 25) !!}
                                </td>
                                <td>
                                    {!! $request['equipment']['name'] !!}
                                </td>
                                <td>
                                    $ {!! number_format($request['cost_rom'],2) !!}
                                </td>
                                <td>
                                    <a type="button" class="btn btn-primary btn-sm" aria-label="Left Align" href="\lccb\{!! $request['id'] !!}\edit">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-request" data-id="{!! $request['id'] !!}" data-token="{{ csrf_token() }}" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/app/my-request.js"></script>
@endsection

@section('css')
@endsection