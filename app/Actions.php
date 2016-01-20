<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Actions extends Model
{
	protected $table = 'actions';

	protected $fillable = [
		'request_id',
		'action',
		'action_status',
		'submitted_by',
		'closed_on',
		'due_on'
	];

	public function request()
	{
		return $this->hasOne('App\Request');
	}

	public function submitted()
	{
		return $this->hasOne('App\User','id','submitted_by');
	}
}