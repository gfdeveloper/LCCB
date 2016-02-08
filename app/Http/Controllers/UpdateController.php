<?php


namespace App\Http\Controllers;


use App\Request;
use Illuminate\Http\Request as HttpRequest;

class UpdateController extends Controller
{
	public function update($id, $action, HttpRequest $request)
	{
		$value = ($request->get('status') == 'true' ? 1 : 0);
		Request::where('id', $id)->update([$action => $value]);
	}
}