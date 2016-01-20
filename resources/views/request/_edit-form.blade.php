<div class="row">
    <input type="hidden" id="request-id" value="{!! $request->id !!}">
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="requested_on">Date Requested</label>

            <div class='input-group date' id='datetimepicker1'>
                <input type='text' name="requested_on" id="requested_on" class="form-control" value="{!! $request->requested_on !!}"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
            <span class="help-block"></span>
        </div>

    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="equipment_id">Equipment</label>
            <input type="hidden" id="equipment_name" value="">

            <div id="equipment">
                <input type="text" name="equipment_id" id="equipment_id" class="form-control typeahead" value="{!! $request->equipment->name !!}">
                <span class="help-block"></span>
            </div>

        </div>


    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="requester_name">Requester Name</label>
            <input type="text" name="requester_name" id="requester_name" class="form-control" value="{!! $request->requester_name !!}">
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

    </div>
</div>

<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="area">Functional Area</label>
            <select name="functional_id" id="functional_id" class="form-control select2">
                @foreach($areas as $area)
                    <option value="{!! $area['id'] !!}" @if($area['id'] == $request['area']['id']) selected @endif>{!! $area['name'] !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="location">Location</label>
            <select name="location_id" id="location_id" class="form-control select2">
                @foreach($locations as $location)
                    <option value="{!! $location['id'] !!}" @if($location['id'] == $request['location']['id']) selected @endif>{!! $location['name'] !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="category">Category</label>
            <select name="category_id" id="category_id" class="form-control select2">
                @foreach($categories as $category)
                    <option value="{!! $category['id'] !!}" @if($category['id'] == $request['category']['id']) selected @endif >{!! $category['name'] !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-3">
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
    <div class="col-xs-4">
        <div class="form-group">
            <label class="control-label" for="schedule_impact">Schedule Impact</label>
            <input type="text" name="schedule_impact" id="schedule_impact" class="form-control" value="{!! $request->schedule_impact !!}">
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            <label class="control-label" for="organization_id">Organization</label>
            <select name="organization_id" id="organization_id" class="form-control select2">
                @foreach($organizations as $org)
                    <option @if($request['organization_id'] == $org['id']) selected @endif value="{!! $org['id'] !!}">{!! $org['name'] !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            <label class="control-label">Cost</label>

            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="form-control" id="cost_rom" name="cost_rom" value="{!! round($request->cost_rom,2) !!}">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="form-group">
            <label class="control-label" for="description">Description</label>
            <textarea name="description" rows="5" cols="20" id="description" class="form-control">{!! $request->description !!}</textarea>
        </div>
        <div class="form-group">
            <label class="control-label" for="business_need">Business Need</label>
            <textarea name="business_need" rows="5" cols="20" id="business_need" class="form-control">{!! $request->business_need !!}</textarea>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label class="control-label" for="if_not_done">Impact If Not Done</label>
            <textarea name="if_not_done" rows="5" cols="20" id="if_not_done" class="form-control">{!! $request->if_not_done !!}</textarea>
        </div>
        <div class="form-group"><label class="control-label" for="alternatives">Alternatives Considered</label>
            <textarea name="alternatives" rows="5" cols="20" id="alternatives" class="form-control">{!! $request->alternatives !!}</textarea>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-xs-12 text-center">

    </div>
</div>


