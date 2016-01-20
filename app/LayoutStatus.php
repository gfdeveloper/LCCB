<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LayoutStatus extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'layout_status';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'request_id',
		'layout_status',
		'submitted_by'
	];
}