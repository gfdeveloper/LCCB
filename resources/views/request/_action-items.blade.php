<div class="row" id="actionsBlock">
    <div class="col-lg-12" id="actionItemList">
        @if(!count($request->actions))
            <div class="row" id="noActionItemsFound">
                <div class="col-lg-12 text-center">
                    <h3>No Action Items</h3>
                </div>
            </div>
        @endif
        @foreach($request->actions as $action)
            <div class="row">
                <div class="timeline-item">
                    <div class="timeline-body">
                        <div class="timeline-body-head">
                            <div class="timeline-body-head-caption">
                                <a href="javascript:;" class="timeline-body-title font-blue-madison">{!! $action->submitted->name !!}</a>
                            <span class="timeline-body-time">
                                Created on {!! $action->created_at->toFormattedDateString() !!} and is due by {!! \Carbon\Carbon::parse($action->due_on)->toFormattedDateString() !!}
                            </span>
                                @if($action->action_status == 'Open')
                                    <span id="label-{!! $action->id !!}" class="label label-danger timeline-title-label">Open</span>
                            </div>

                            <div class="timeline-body-head-actions" id="actions-{!! $action->id !!}">
                                <div class="btn-group">
                                    <button class="btn btn-xs btn-success" data-action_id="{!! $action->id !!}" type="button">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Complete
                                    </button>
                                </div>
                            </div>@else
                                <span id="label-{!! $action->id !!}" class="label label-success timeline-title-label">Closed on {!! $action->closed_on !!}</span>
                        </div>@endif


                    </div>
                    <div class="timeline-body-content">
						<span class="font-grey-cascade">
                            {!! $action->action !!}
                        </span>
                    </div>
                </div>
            </div>
    </div>@endforeach
</div></div>

<script id="actionItemsTemplate" type="text/x-handlebars-template">
    <div class="row">
        <div class="timeline-item">
            <div class="timeline-body">
                <div class="timeline-body-head">
                    <div class="timeline-body-head-caption">
                        <a href="javascript:;" class="timeline-body-title font-blue-madison">@{{submitted_by}}</a>
                            <span class="timeline-body-time">
                                Created on @{{created_at}} and is due by @{{due_on}}
                            </span> <span id="label-@{{id}}" class="label label-danger timeline-title-label">Open</span>
                    </div>
                    <div class="timeline-body-head-actions">
                        <div class="btn-group">
                            <button class="btn btn-xs btn-success" type="button" data-action_id="@{{id}}">
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Complete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="timeline-body-content">
						<span class="font-grey-cascade">
                            @{{action}}
                        </span>
                </div>
            </div>
        </div>
    </div>
</script>