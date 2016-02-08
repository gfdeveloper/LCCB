<?php
namespace App\Http\Controllers;


use App\Approval;
use App\Area;
use App\Category;
use App\Equipment;
use App\Events\CommentWasSubmitted;
use App\Events\RequestWasSubmitted;
use App\Http\Requests\LCCBRequest;
use App\Location;
use App\Organization;
use App\Request;
use App\Role;
use App\Upload;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;

class LCCBController extends Controller
{

	public function dummy()
	{
		$lccb = Request::with('Approvers')->where('status_id', 5)->whereBetween('requested_on', [$start, $end])->get($columns);
		$total = 0;
		$count = 0;
		foreach ($lccb as $calculate) {
			//echo $calculate->requested_on."<br>";
			$lccbDate = new Carbon($calculate->requested_on);
			foreach ($calculate->approvers as $approval) {
				$date[] = new Carbon($approval->created_at);
			}
			$max = $date[0]->max($date[1]);
			$max = Carbon::parse('2015-08-10');
			$diff = $max->diffInSeconds($lccbDate);
			$total += $diff;
			$count++;
			unset($date);
		}
	}

	public function create()
	{
		$data['areas'] = Area::all(['id', 'name']);
		$data['categories'] = Category::all(['id', 'name']);
		$data['locations'] = Location::all(['id', 'name']);
		$data['organizations'] = Organization::all(['id', 'name']);
		$data['user_org_id'] = Auth::User()->organization->id;
		return view('request.create', $data);
	}

	public function show($id)
	{
		$request = Request::with('equipment', 'area', 'location', 'category', 'uploads', 'approvers', 'status')->findOrFail($id);
		$data['request'] = $request;
		$data['areas'] = Area::all(['id', 'name']);
		$data['categories'] = Category::all(['id', 'name']);
		$data['locations'] = Location::all(['id', 'name']);
		$data['approvers'] = Approval::getRecent($id);

		return view('request.view', $data);
	}

	public function edit($id)
	{
		$request = Request::with([
			'equipment',
			'area',
			'location',
			'category',
			'uploads',
			'approvers',
			'status',
			'actions' => function ($query) {
				$query->orderBy('created_at', 'desc');
			},
			'actions.submitted',
			'comments.author' => function ($query) {
				$query->orderBy('created_at', 'asc');
			}
		])
			->find($id);

		if(is_null($request)) {
			return view('security.not-found');
		}

		if ($request->submitted_by != Auth::User()->id && !Auth::User()->hasRole(['administrator', 'approver'])) {
			return view('security.401');
		}

		$data['request'] = $request;
		$data['areas'] = Area::all(['id', 'name']);
		$data['organizations'] = Organization::all();
		$data['categories'] = Category::all(['id', 'name']);
		$data['locations'] = Location::all(['id', 'name']);
		$data['approvers'] = Approval::getRecent($id);
		$data['hasApproved'] = Approval::hasApproved($id)->exists();

		if ($request->Status->name == 'Approved') {
			return view('request.view', $data);
		}


		return view('request.edit', $data);
	}

	public function attach($id, \Illuminate\Http\Request $request)
	{
		foreach ($request->file('files') as $file) {
			Upload::create([
				'request_id' => $id,
				'file_name' => $file->getClientOriginalName()
			]);
			$destinationPath = 'D:\www\lccb\uploads\lccbRequests\\' . $id;
			$file->move($destinationPath, $file->getClientOriginalName());
		}

		$event = Request::find($id);
		Event::fire(new CommentWasSubmitted($event));

		return $id;
	}

	public function update($id, LCCBRequest $request)
	{
		$update = Request::findOrFail($id);

		if (is_string($request->equipment_id)) {
			$newEquip = Equipment::firstOrNew([
				'name' => $request->equipment_id
			]);
			$newEquip->user_id = Auth::user()->id;
			$newEquip->save();
			$request->request->set('equipment_id', $newEquip->id);
		}

		$update->update($request->all());

		if (!is_null($request->file('files'))) {
			foreach ($request->file('files') as $file) {
				Upload::create([
					'request_id' => $id,
					'file_name' => $file->getClientOriginalName()
				]);
				$destinationPath = 'D:\www\lccb\uploads\lccbRequests\\' . $id;
				$file->move($destinationPath, $file->getClientOriginalName());
			}
		}

		$json['success'] = 1;
		$json['title'] = "Bingo!";
		$json['message'] = "Request updated successfully";

		return json_encode($json);
	}

	public function store(LCCBRequest $request)
	{
		$request->request->add(['submitted_by' => Auth::user()->id]);

		if (is_string($request->equipment_id)) {
			$newEquip = Equipment::firstOrNew([
				'name' => $request->equipment_id
			]);
			$newEquip->user_id = Auth::user()->id;
			$newEquip->save();
			$request->request->set('equipment_id', $newEquip->id);
		}

		$newRequest = Request::create($request->all());

		if (!is_null($request->file('files'))) {
			foreach ($request->file('files') as $file) {
				Upload::create([
					'request_id' => $newRequest->id,
					'file_name' => $file->getClientOriginalName()
				]);
				$destinationPath = 'D:\www\lccb\uploads\lccbRequests\\' . $newRequest->id;
				$file->move($destinationPath, $file->getClientOriginalName());
			}
		}

		Event::fire(new RequestWasSubmitted($newRequest));

		$json['success'] = 1;
		$json['message'] = "Request saved";
		$json['redirect'] = "/lccb/" . $newRequest->id . "/edit";

		return json_encode($json);
	}

	public function destroy($id)
	{
		$request = Request::find($id);
		if ($request->submitted_by != Auth::User()->id && !Auth::User()->hasRole(['administrator', 'approver'])) {
			return view('security.401');
		}

		Request::destroy($id);
	}

	public function fieldWalk($id)
	{
		if(!Auth::User()->hasRole(['administrator', 'approver'])) {
			return view('security.401');
		}

		Request::where('id', $id)->update(['field_walk' => 1]);

		return redirect()->back();

	}

}