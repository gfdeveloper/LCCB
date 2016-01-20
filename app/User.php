<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'organization_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function Approvals()
    {
        return $this->hasMany('App\Approval');
    }

    public function Requests()
    {
        return $this->hasMany('App\Request');
    }

    public function Organization()
    {
        return $this->belongsTo('App\Organization','organization_id','id');
    }

	public function Equipment()
	{
		return $this->hasMany('App\Equipment');
	}

	public function scopeHasApproved($query, $request_id)
	{
//		if($query->whereHas('approvals', function($q) use($request_id) {
//			$q->where('request_id', $request_id)
//				->where('user_id', Auth::User()->id)->get();
//		})) {
//			return true;
//		}
//		return false;

		//return $query->where()
	}
}
