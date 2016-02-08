<?php

namespace app\Http\Controllers\Reports;


use App\Actions;
use App\Approval;
use App\Http\Controllers\Controller;
use App\Request;
use Illuminate\Support\Facades\DB;

class MeetingMinutes extends Controller
{
	public function run()
	{
		return view('reports.minutes');
	}

	public function build($start, $end)
	{
		return Request::with('comments')
			->select([
				'requests.description',
				'requests.id',
				'o.name AS organization',
				'e.name AS equipment',
				'cat.name AS category',
				'requests.requester_name AS requester',
				'status.name AS status',
				'requests.layout_updated',
				'requests.design_updated',
				'requests.mw_updated'
			])
			->join('organizations AS o', 'o.id', '=', 'requests.organization_id')
			->join('equipment AS e', 'e.id', '=', 'requests.equipment_id')
			->join('categories AS cat', 'cat.id', '=', 'requests.category_id')
			->join('status AS status', 'status.id', '=', 'requests.status_id')
			->whereBetween('requests.requested_on', [$start, $end])
			->whereNull('requests.deleted_at')
			->get();
	}

	public function buildApprove($start, $end)
	{
		return Approval::select([
			'approvals.choice',
			'approvals.comment',
			'approvals.created_at',
			'u.name AS approver',
			'r.description AS description',
			'approvals.request_id AS id'
		])
			->join('users AS u', 'u.id', '=', 'approvals.user_id')
			->join('requests AS r', 'r.id', '=', 'approvals.request_id')
			->whereBetween('approvals.created_at', [$start, $end])
			->get();
	}

	public function buildActions($start, $end)
	{
		return Actions::select([
			'actions.request_id AS r_id',
			'actions.id AS a_id',
			'actions.action AS action_item',
			'actions.action_status AS status',
			'u.name AS submitter',
			'actions.due_on',
			'actions.created_at'
		])
			->join('users AS u', 'u.id', '=', 'actions.submitted_by')
			->where('action_status','Open')
			->get();
	}

}