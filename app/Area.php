<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Area extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'areas';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];

	public function Requests()
	{
		return $this->hasMany('App\Request');
	}
}