<?php
/**
 * Created by PhpStorm.
 * User: app_ccarver
 * Date: 6/16/2015
 * Time: 4:04 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Status extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'status';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'slug'
	];

	public function Request()
	{
		return $this->hasMany('App\Request', 'status', 'id');
	}
}