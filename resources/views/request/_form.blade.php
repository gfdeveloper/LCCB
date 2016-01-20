<input type="hidden" name="status_id" value="1">
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="requested_on">Date Requested</label>

            <div class='input-group date' id='datetimepicker1'>
                <input type='text' name="requested_on" id="requested_on" class="form-control"/>
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
                <input type="text" name="equipment_id" id="equipment_id" class="form-control typeahead">
                <span class="help-block"></span>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="requester_name">Requester Name</label>
            <input type="text" name="requester_name" id="requester_name" class="form-control" value="{!! Auth::user()->name !!}">
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label class="control-label" for="organization_id">Organization</label>
            <select name="organization_id" id="organization_id" class="form-control select2">
                @foreach($organizations as $org)
                    <option @if($user_org_id == $org['id']) selected @endif value="{!! $org['id'] !!}">{!! $org['name'] !!}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-xs-4">
        <div class="form-group">
            <label class="control-label" for="area">Functional Area</label>
            <select name="functional_id" id="functional_id" class="form-control select2">
                @foreach($areas as $area)
                    <option value="{!! $area['id'] !!}">{!! $area['name'] !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            <label class="control-label" for="location">Location</label>
            <select name="location_id" id="location_id" class="form-control select2">
                @foreach($locations as $location)
                    <option value="{!! $location['id'] !!}">{!! $location['name'] !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            <label class="control-label" for="category">Category</label>
            <select name="category_id" id="category_id" class="form-control select2">
                @foreach($categories as $category)
                    <option value="{!! $category['id'] !!}">{!! $category['name'] !!}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-8">
        <div class="form-group">
            <label class="control-label" for="schedule_impact">Schedule Impact</label>
            <input type="text" name="schedule_impact" id="schedule_impact" class="form-control">
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            <label class="control-label">Cost</label>

            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="form-control" id="cost_rom" name="cost_rom">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="form-group">
            <label class="control-label" for="description">Description</label>
            <textarea name="description" rows="5" cols="20" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label class="control-label" for="business_need">Business Need</label>
            <textarea name="business_need" rows="5" cols="20" id="business_need" class="form-control"></textarea>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label class="control-label" for="if_not_done">Impact If Not Done</label>
            <textarea name="if_not_done" rows="5" cols="20" id="if_not_done" class="form-control"></textarea>
        </div>
        <div class="form-group"><label class="control-label" for="alternatives">Alternatives Considered</label>
            <textarea name="alternatives" rows="5" cols="20" id="alternatives" class="form-control"></textarea>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            <div id="myDrop" class="dropzone">
                <div class="dz-default dz-message"><span><i class="fa fa-cloud-upload fa-3x"></i><br>File Upload</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 text-center">
        <button type="button" class="btn" id="submitForm">Submit!</button>
    </div>
</div>


