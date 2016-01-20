<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Approval extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'approvals';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'request_id',
		'user_id',
		'organization_id',
		'approved_offline',
		'choice',
		'comment'
	];

	public function User()
	{
		return $this->hasOne('App\User');
	}

	public function Request()
	{
		return $this->belongsTo('App\Request');
	}

	public static function getRecent($request_id)
	{
		return DB::select("
			SELECT * FROM (
    			SELECT approvals.*, users.name AS name, organizations.name AS org
    			FROM approvals
                INNER JOIN users ON approvals.user_id = users.id
                INNER JOIN organizations ON organizations.id = approvals.organization_id
                WHERE approvals.request_id = ?
                ORDER BY approvals.created_at DESC
    			LIMIT 2
			) as results
			GROUP BY user_id
		", [$request_id]);
	}

	public function scopeHasApproved($query, $request_id)
	{
		return $query->where('request_id', '=', $request_id)->where('user_id', '=', Auth::User()->id);
	}
}
