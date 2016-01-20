<?php
/**
 * Created by PhpStorm.
 * User: app_ccarver
 * Date: 6/9/2015
 * Time: 3:21 PM
 */

namespace App\Http\Controllers;


use App\Actions;
use App\Area;
use App\Category;
use App\Comment;
use App\Equipment;
use App\Location;
use App\Organization;
use App\Role;
use App\Upload;
use App\User;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;

class ApiController extends Controller
{

	public function getOpenActions()
	{
		return Actions::where('action_status', 'Open')->get()->count();
	}

	public function equipmentSearch($q)
	{
		$json = [];
		$results = Equipment::where('name', 'LIKE', "%$q%")->take(10)->lists('name', 'id');
		foreach ($results as $key => $value) {
			$json[] = array(
				'id' => $key,
				'value' => $value
			);
		}
		return json_encode($json);
	}

	public function showLocations(Request $request)
	{
		$q = $request->input('q');
		$json['results'] = [];
		$results = Location::where('name', 'LIKE', "%$q%")->take(10)->lists('name', 'id');
		foreach ($results as $key => $value) {
			$json['results'][] = array(
				'id' => $key,
				'text' => $value
			);
		}
		return json_encode($json);
	}

	public function showAreas(Request $request)
	{
		$json['results'] = [];
		$q = $request->input('q');
		$results = Area::where('name', 'LIKE', "%$q%")->take(10)->lists('name', 'id');
		foreach ($results as $key => $value) {
			$json['results'][] = array(
				'id' => $key,
				'text' => $value
			);
		}
		return json_encode($json);
	}

	public function showCategories(Request $request)
	{
		$json['results'] = [];
		$q = $request->input('q');
		$results = Category::where('name', 'LIKE', "%$q%")->take(10)->lists('name', 'id');
		foreach ($results as $key => $value) {
			$json['results'][] = array(
				'id' => $key,
				'text' => $value
			);
		}
		return json_encode($json);
	}

	public function users()
	{
		$users = User::with('organization', 'roles')->get(['id', 'name', 'email', 'organization_id']);
		$orgs = Organization::all();
		$roles = Role::all();

		return Datatables::of($users)
			->addColumn('organization', function ($user) use ($orgs) {
				$orgSelect = '<select name="organization" class="form-control organization" data-userid="' . $user->id . '">';
				foreach ($orgs as $org) {
					$select = "";
					if ($org->id == $user->organization_id)
						$select = 'selected';
					$orgSelect .= '<option value="' . $org->id . '" ' . $select . '>' . $org->name . '</option>';
				}
				$orgSelect .= '</select>';
				//return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> '.$user->organization->name.'</a>';
				return $orgSelect;
			})
			->addColumn('role', function ($user) use ($roles) {
				$roleSelect = '<select name="organization" class="form-control role" data-userid="' . $user->id . '">';
				foreach ($roles as $role) {
					$select = "";
					if ($user->hasRole($role->name))
						$select = 'selected';
					$roleSelect .= '<option value="' . $role->id . '" ' . $select . '>' . $role->display_name . '</option>';
				}
				$roleSelect .= '</select>';
				//return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> '.$user->roles[0]->display_name.'</a>';
				return $roleSelect;
			})
			->removeColumn('id')
			->removeColumn('organization_id')
			->make(true);
	}

	public function showOrg()
	{
		$orgs = Organization::select(['name', 'id'])->get();

		return Datatables::of($orgs)
			->addColumn('action', function ($user) {
				return '<button data-name="' . $user->name . '" data-id="' . $user->id . '" class="edit-vendor btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
			})
			->removeColumn('id')
			->make(true);
	}

	public function saveOrg(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|unique:organizations',
		]);

		Organization::create($request->all());

		return "GTG";
	}

	public function updateOrganization($id, Request $request)
	{
		$this->validate($request, [
			'name' => 'required|unique:organizations,name,'.$id,
		]);

		Organization::where('id', $id)->update(['name' => $request->get('name')]);

		return "GTG";
	}

	public function updateOrg($userid, $orgid)
	{
		User::where('id', $userid)->update(['organization_id' => $orgid]);
		$json = array(
			'status' => '1',
			'messageTitle' => 'Success!',
			'message' => 'User organization updated'
		);

		return $json;
	}

	public function updateRole($userid, $roleid)
	{
		$user = User::where('id', $userid)->first();
		$user->attachRole($roleid);
		$json = array(
			'status' => '1',
			'messageTitle' => 'Success!',
			'message' => 'User role updated'
		);

		return $json;
	}

	public function uploads($requestId)
	{
		$uploads = Upload::where('request_id', $requestId)->get();
		$output = '<li class="list-group-item text-center"><h4>Current Uploaded Files</h4></li>';
		foreach ($uploads as $upload) {
			$output .=
				'<li class="list-group-item" id="file-' . $upload->id . '">
					<a href="/download/' . $upload->id . '/direct" title="Download File"><span class="badge"><i class="fa fa-download"></i></span></a>
					<a href="#" data-fileid="' . $upload->id . '" title="Delete File" class="delete-file"><span class="badge"><i class="fa fa-trash-o"></i></span></a>
                    <a class="pdf cboxElement" href="/download/' . $upload->id . '" title="View File">' . str_limit($upload->file_name, $limit = 35, $end = '...') . '</a>
				</li>';
		}

		return $output;
	}

	public function comments($id)
	{
		$comments = Comment::with('Author')->where('request_id', $id)->orderBy('created_at', 'desc')->get();
		$output = '';

		foreach ($comments as $comment) {
			$output .= '
			<div class="media">
                <div class="media-body">
                    <h4 class="media-heading">' . $comment->comment . '</h4>
                    ' . $comment->author->name . ' @ ' . $comment->created_at . '
				</div>
            </div>
			';
		}

		return $output;

	}
}