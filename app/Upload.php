<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'uploads';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['request_id','file_name'];

	public function Requests()
	{
		return $this->belongsTo('App\Request');
	}
}