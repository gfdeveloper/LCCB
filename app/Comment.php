<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	protected $table = 'comments';

	protected $fillable = [
		'comment',
		'user_id',
		'request_id'
	];

	public function Request()
	{
		return $this->belongsTo('App\Request');
	}

	public function Author()
	{
		return $this->belongsTo('App\User','user_id','id');
	}
}