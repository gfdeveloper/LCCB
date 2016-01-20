<?php
/**
 * Created by PhpStorm.
 * User: app_ccarver
 * Date: 6/12/2015
 * Time: 2:58 PM
 */

namespace App\Http\Controllers;


use App\Request;

class UserController extends Controller{

	public function myRequests()
	{
		$data['requests'] = Request::with('Requester','Location','Equipment','Category','Area','Uploads','Status')->user()->get()->toArray();
		return view('user.myRequests', $data);
	}
}