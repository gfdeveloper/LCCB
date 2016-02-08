<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Request extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'functional_id',
        'location_id',
        'category_id',
        'equipment_id',
	    'organization_id',
        'schedule_impact',
        'requester_name',
        'cost_rom',
        'description',
        'business_need',
        'if_not_done',
        'alternatives',
        'requested_on',
	    'submitted_by',
	    'status_id',
	    'layout_updated',
	    'design_updated',
	    'mw_updated',
	    'field_walk'
    ];

	protected $casts = [
		'layout_updated' => 'boolean',
		'design_updated' => 'boolean',
		'mw_updated' => 'boolean',
		'field_walk' => 'boolean',
	];

	use SoftDeletes;

	public function actions()
	{
		return $this->hasMany('App\Actions');
	}

	public function scopeUser($query)
	{
		return $query->where('submitted_by', Auth::user()->id);
	}

    public function Requester()
    {
        return $this->belongsTo('App\User','submitted_by');
    }

	public function Equipment()
	{
		return $this->belongsTo('App\Equipment');
	}

	public function Location()
	{
		return $this->belongsTo('App\Location');
	}

	public function Area()
	{
		return $this->belongsTo('App\Area', 'functional_id');
	}

	public function Category()
	{
		return $this->belongsTo('App\Category');
	}

	public function Status()
	{
		return $this->belongsTo('App\Status', 'status_id', 'id');
	}

	public function Uploads()
	{
		return $this->hasMany('App\Upload');
	}

	public function Approvers()
	{
		return $this->hasMany('App\Approval');
	}

	public function scopeRequestStatus($query, $status)
	{
		return $query->where('status_id', $status);
	}

	public function Comments()
	{
		return $this->hasMany('App\Comment')->orderBy('created_at','desc');
	}

	public function scopeRequestStatusSlug($query, $status)
	{
		//return $query->where('slug', $status);
		return $query->whereHas('status', function($q) use($status){
			$q->where('slug', $status);
		});
	}

	public function scopeCalcDaysOpen($query, $created)
	{
		$created = new Carbon($created);
		$now = Carbon::now();
		if($created->diff($now, false)->days < 0) {
			return 1;
		} else {
			//return "?";
			//return $created->diffInDays($now, false);
			return ($created->diff($now, false)->days < 1)	? '1' : $created->diffInDays($now);
		}
		//return ($created->diff($now, false)->days < 0)	? '1' : $created->diffInDays($now);
	}

	public function scopeGetComments($query, $id)
	{
		return;
	}

}
