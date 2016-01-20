<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class LCCBRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	    return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	        'requester_name' => 'required|max:255',
	        'requested_on' => 'required|date|date_format:Y-m-d H:i:s',
	        'equipment_id' => 'required',
	        'schedule_impact' => 'required',
	        'location_id' => 'required',
	        'functional_id' => 'required',
	        'category_id' => 'required',
	        'organization_id' => 'required',
	        'cost_rom' => 'required|numeric',
	        'description' => 'required',
	        'business_need' => 'required',
	        'if_not_done' => 'required',
	        'alternatives' => 'required'
        ];
    }
}
