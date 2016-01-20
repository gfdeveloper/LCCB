<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="requested_on">Date Requested</label>
            <input type='text' readonly class="form-control" value="{!! $request->requested_on !!}"/>
        </div>
        <div class="form-group">
            <label class="control-label" for="requester_name">Requester Name</label>
            <input type="text" readonly class="form-control" value="{!! $request->requester_name !!}">
        </div>


    </div>
    <div class="col-xs-3">

        <div class="form-group">
            <label class="control-label" for="equipment_id">Equipment</label>
            <input type="hidden" id="equipment_name" value="">
            <input type="text" readonly class="form-control" value="{!! $request->equipment->name !!}">
        </div>

        <div class="form-group">
            <label class="control-label" for="location">Location</label>
            <input type="text" readonly class="form-control typeahead" value="{!! $request->location->name !!}">
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="area">Functional Area</label>
            <input type="text" readonly class="form-control typeahead" value="{!! $request->area->name !!}">
        </div>
        <div class="form-group">
            <label class="control-label" for="category">Category</label>
            <input type="text" readonly class="form-control typeahead" value="{!! $request->category->name !!}">
        </div>
    </div>

    <div class="col-xs-3">

        <div class="form-group">
            @if(isset($approvers['0']))
                <label class="control-label" for="area">{!! $approvers['0']->choice !!} @ {!! $approvers['0']->updated_at !!}</label>
            @else
                <label class="control-label" for="area">Approver</label>
            @endif
            <input type="text" readonly name="approver_one" id="approver_one" class="form-control" value=" @if(isset($approvers['0'])) {!! $approvers['0']->name !!} @endif">
        </div>
        <div class="form-group">
            @if(isset($approvers['1']))
                <label class="control-label" for="area">{!! $approvers['1']->choice !!} @ {!! $approvers['1']->updated_at !!}</label>
            @else
                <label class="control-label" for="area">Approver</label>
            @endif
            <input type="text" readonly name="approver_two" id="approver_two" class="form-control" value=" @if(isset($approvers['1'])) {!! $approvers['1']->name !!} @endif">
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xs-8">
        <div class="form-group">
            <label class="control-label" for="schedule_impact">Schedule Impact</label>
            <input type="text" readonly class="form-control" value="{!! $request->schedule_impact !!}">
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            <label class="control-label">Cost</label>

            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="form-control" readonly value="{!! round($request->cost_rom,2) !!}">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            <label class="control-label" for="description">Description</label>
            <textarea class="form-control" rows="5" cols="20" readonly>{!! $request->description !!}</textarea>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label class="control-label" for="business_need">Business Need</label>
            <textarea rows="5" cols="20" readonly class="form-control">{!! $request->business_need !!}</textarea>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label class="control-label" for="if_not_done">Impact If Not Done</label>
            <textarea rows="5" cols="20" readonly class="form-control">{!! $request->if_not_done !!}</textarea>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group"><label class="control-label" for="alternatives">Alternatives Considered</label>
            <textarea rows="5" cols="20" readonly class="form-control">{!! $request->alternatives !!}</textarea>
        </div>
    </div>

</div>


