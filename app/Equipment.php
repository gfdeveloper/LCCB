<?php
/**
 * Created by PhpStorm.
 * User: app_ccarver
 * Date: 6/9/2015
 * Time: 3:44 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Equipment extends Model {

	protected $table = 'equipment';

	protected $fillable = [
		'name',
		'user_id'
	];

	public function Requests()
	{
		return $this->hasMany('App\Request');
	}

	public function User()
	{
		return $this->belongsTo('App\User');
	}
}