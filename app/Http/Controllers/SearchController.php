<?php
namespace app\Http\Controllers;



use Illuminate\Http\Request;
use yajra\Datatables\Datatables;

class SearchController extends Controller
{
	public function index()
	{
		return view('search.index');
	}

	public function getRequests(Request $request)
	{
		//$lccb = \App\Request::with('equipment', 'area', 'location', 'category', 'uploads', 'approvers', 'status', 'requester.organization');

		$lccb = \App\Request::join('areas', 'requests.functional_id', '=', 'areas.id')
				->join('categories', 'requests.category_id', '=' ,'categories.id')
				->join('equipment', 'requests.equipment_id', '=', 'equipment.id')
				->join('users', 'requests.submitted_by', '=', 'users.id')
				->join('organizations', 'users.organization_id', '=', 'organizations.id')
				->join('status', 'requests.status_id', '=', 'status.id')
				->join('locations', 'requests.location_id', '=' ,'locations.id')
				->select(
					'requests.*',
					'areas.name AS area',
					'categories.name AS category',
					'equipment.name AS equipment',
					'users.name AS requester',
					'organizations.name AS organization',
					'status.name AS status',
					'locations.name AS location'
				);

		$datatables = Datatables::of($lccb)
			->editColumn('id', function($lccb){
				return "<a href='/lccb/".$lccb->id."/edit'>".$lccb->id."</a>";
			});

		return $datatables->make(true);
	}
}