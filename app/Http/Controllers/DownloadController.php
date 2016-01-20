<?php

namespace App\Http\Controllers;


use App\Request;
use App\Upload;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{

	public function download($id)
	{
		$file = Upload::findOrFail($id);
		$path = base_path()."/uploads/lccbRequests/".$file->request_id."/".$file->file_name;
		if (file_exists($path))
		{
			//return response()->download(base_path()."/uploads/lccbRequests/".$file->file_name);
			return response()->make(file_get_contents($path), 200, [
				'Content-Type' => 'application/pdf',
				'Content-Disposition' => 'inline; '.$file->file_name,
			]);
		}
	}
	public function save($id)
	{
		$file = Upload::findOrFail($id);
		$path = base_path()."/uploads/lccbRequests/".$file->request_id."/".$file->file_name;
		if (file_exists($path))
		{
			return response()->download($path);
		}
	}

	public function delete($id)
	{
		$file = Upload::findOrFail($id);

		$request = Request::find($file->request_id);
		if ($request->submitted_by != Auth::User()->id && !Auth::User()->hasRole(['administrator', 'approver'])) {
			return view('security.401');
		}

		if(unlink('D:\www\lccb\uploads\lccbRequests\\' . $request->id . '\\' . $file->file_name)) {
			Upload::destroy($id);
			return $id;
		} else {
			return "error";
		}
	}

}