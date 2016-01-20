<?php

namespace App\Http\Controllers;


use App\Approval;
use App\Events\ActionItemApproved;
use App\Events\ApprovalWasSubmitted;

use App\Events\FinalStatusSubmitted;
use App\LayoutStatus;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class ApprovalController extends Controller
{

	public function show($slug)
	{
		$data['requests'] = \App\Request::with('status', 'equipment')->requestStatusSlug($slug)->get();
		return view('approval.index', $data);
	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return Request
	 */
	public function approve($id, Request $request)
	{
		if (!Approval::hasApproved($id)->exists()) {
			$current = Approval::create([
				'request_id' => $id,
				'user_id' => Auth::User()->id,
				'organization_id' => Auth::User()->organization_id,
				'approved_offline' => $request->input('approved-offline'),
				'comment' => $request->input('comments'),
				'choice' => 'Approve'
			]);

			$submittal = \App\Request::find($id);
			$approvals = Approval::where('request_id',$id)->get();

			$status = array(
				'Approve' => 0,
				'Reject' => 0
			);

			foreach ($approvals as $approval) {
				$status[$approval->choice]++;
			}

			$json = $this->updateStatus($submittal, $status);
			return json_encode($json);
		} else {
			$json = array(
				'error' => true,
				'message' => 'You have already approved this request.'
			);
		}
	}

	public function reject($id, Request $request)
	{
		if (!Approval::hasApproved($id)->exists()) {
			$current = Approval::create([
				'request_id' => $id,
				'user_id' => Auth::User()->id,
				'organization_id' => Auth::User()->organization_id,
				'approved_offline' => $request->input('approved-offline'),
				'comment' => $request->input('comments'),
				'choice' => 'Reject'
			]);

			$submittal = \App\Request::find($id);
			$approvals = Approval::getRecent($id);

			$status = array(
				'Approve' => 0,
				'Reject' => 0
			);

			foreach ($approvals as $approval) {
				$status[$approval->choice]++;
			}

			$json = $this->updateStatus($submittal, $status);
			return json_encode($json);
		} else {
			$json = array(
				'error' => true,
				'message' => 'You have already approved this request.'
			);
		}
	}

	public function revoke($id)
	{
		Approval::where('request_id', $id)->where('user_id', Auth::user()->id)->delete();
		$approvals = Approval::getRecent($id);

		$status = array(
			'Approve' => 0,
			'Reject' => 0
		);

		foreach ($approvals as $approval) {
			$status[$approval->choice]++;
		}
		$sub = \App\Request::find($id);

		$this->updateStatus($sub, $status);

		return response()->json([
			'status' => 'success'
		]);
	}

	public function setStatus($id, $status)
	{
		//dd($status);
		if (Auth::User()->hasRole('administrator') || Auth::User()->hasRole('approver')) {
			$update = Status::select('id', 'name')->where('slug', $status)->first();
			\App\Request::where('id', $id)->update(['status_id' => $update->id]);
			return response()->json([
				'status' => 'success',
				'message' => $update->name
			]);
		}
	}

	protected function updateStatus(\App\Request $request, $status)
	{
		if ($status['Approve'] == 2) {
			$request->status_id = 5;
			$json['status'] = 'Approved';
			LayoutStatus::create([
				'request_id' => $request->id,
				'layout_status' => "Waiting for Layout Update",
				'submitted_by' => Auth::User()->id
			]);
			Event::fire(new FinalStatusSubmitted($request));
			Event::fire(new ActionItemApproved($request));
		} elseif ($status['Approve'] == 1 && $status['Reject'] == 1) {
			$request->status_id = 2;
			$json['status'] = 'Open/Needs Further Review';
		} elseif ($status['Approve'] == 0 && $status['Reject'] == 1) {
			$request->status_id = 2;
			$json['status'] = 'Open/Needs Further Review';
		} elseif ($status['Reject'] == 2) {
			$request->status_id = 4;
			$json['status'] = 'Rejected';
			Event::fire(new FinalStatusSubmitted($request));
		} elseif ($status['Approve'] == 0 && $status['Reject'] == 0) {
			$request->status_id = 1;
			$json['status'] = 'New';
		} elseif ($status['Approve'] == 1 && $status['Reject'] == 0) {
			$request->status_id = 3;
			$json['status'] = 'Waiting for Approval';
		} else {
			$request->status_id = 3;
			$json['status'] = 'Waiting for Approval';
		}
		$request->save();

		return $json;
	}

}