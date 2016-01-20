<?php

namespace App\Http\Controllers;

use App\Approval;
use App\Category;
use Carbon\Carbon;
use DateTime;
use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
	public function organization($start, $end)
	{
		$chart = new Highchart();
		$categories = Category::get(['name']);

		$requests = DB::table('requests AS r')
			->select(['o.name AS name', 'c.name AS category'])
			->join('users AS u', 'r.submitted_by', '=', 'u.id')
			->join('organizations AS o', 'r.organization_id', '=', 'o.id')
			->join('categories AS c', 'c.id', '=', 'r.category_id')
			->whereRaw("requested_on BETWEEN DATE_SUB('".$start."', INTERVAL 1 DAY) AND DATE_ADD('".$end."', INTERVAL 1 DAY)")->get();

		if (empty($requests)) {
			$json = [
				'status' => 'error',
				'title' => 'Error',
				'message' => 'No data was found within the date range selected!'
			];
			return $json;
		}

		foreach ($requests as $request) {
			foreach ($categories as $cat) {
				$array[$request->name][$cat->name] = 0;
			}
		}
		foreach ($requests as $request) {
			$array[$request->name][$request->category]++;
		}

		foreach ($array as $key => $value) {
			$displayOrg[] = $key;
			foreach($value as $cat => $total){
				$totals[$cat][] = $total;
			}
		}

		foreach($totals as $key =>$package) {
			foreach($package as $value){
				$data[] = $value;
			}
			$chart->series[] = array(
				'name' => $key,
				'data' => $data
			);
			unset($data);
		}


		foreach ($requests as $request) {
			@$orgs[$request->requester->organization->name]++;
		}
		arsort($orgs);

		$chart->yAxis->stackLabels->enabled = 1;
		$chart->plotOptions->column->stacking = "normal";
		$chart->plotOptions->column->dataLabels->enabled = 1;
		$chart->credits->enabled = false;
		$chart->chart = array(
			'type' => 'column'
		);
		//$chart->colors = array(
		//	"#A2DED0"
		//);
		$chart->title = array(
			'text' => ''
		);
		//$chart->legend->enabled = false;
		$chart->xAxis->categories = $displayOrg;
		$chart->yAxis = array(
			'title' => array(
				'text' => '# of requests'
			)
		);

		echo $chart->renderOptions();
	}

	public function approvals($start, $end)
	{
		$columns = [
			'id', 'approved_offline'
		];
		$approvals = Approval::whereBetween('created_at', [$start, $end])->get($columns);
		if ($approvals->isEmpty()) {
			$json = [
				'status' => 'error',
				'title' => 'Error',
				'message' => 'No approvals found in this date range!'
			];
			return $json;
		}
		$offline = $online = 0;
		foreach ($approvals as $approval) {
			if ($approval['approved_offline']) {
				$offline++;
			} else {
				$online++;
			}
		}

		$chart = new Highchart();
		$chart->chart->height = "250";
		$chart->credits->enabled = false;
		$chart->title->text = "";
		$chart->plotOptions->pie->colors = array(
			"#D4D4D4",
			"#8DB6CD"
		);

		$data[] = array(
			"Offline",
			$offline
		);
		$data[] = array(
			"Online",
			$online
		);

		$chart->series[] = array(
			'type' => "pie",
			'name' => "Approvals",
			'data' => $data
		);

		echo $chart->renderOptions();
	}

	public function averageToApprove($start, $end)
	{
		$columns = [
			'id',
			'status_id',
			'requested_on'
		];
		//$lccb = \App\Request::with('Approvers')->where('status_id', 5)->whereBetween('created_at', [$start, $end])->get($columns);
		$lccb = \App\Request::with('Approvers')->where('status_id', 5)->whereBetween('requested_on', [$start, $end])->get($columns);

//		$test = DB::table('requests')->select(DB::raw(
//			'AVG(TIMESTAMPDIFF(SECOND,
//				requested_on,
//				contactdatetimecomplete)
//			) AS average'));

		$statistics = DB::table('requests')->select(
			DB::raw("COUNT(status_id) AS total"),
			DB::raw("SUM(CASE WHEN status_id = 1 THEN 1 ELSE 0 END) AS new"),
			DB::raw("SUM(CASE WHEN status_id = 2 THEN 1 ELSE 0 END) AS open"),
			DB::raw("SUM(CASE WHEN status_id = 3 THEN 1 ELSE 0 END) AS waiting"),
			DB::raw("SUM(CASE WHEN status_id = 4 THEN 1 ELSE 0 END) AS rejected"),
			DB::raw("SUM(CASE WHEN status_id = 5 THEN 1 ELSE 0 END) AS approved")
		)
			->whereNull('deleted_at')
			->whereRaw("requested_on BETWEEN DATE_SUB('".$start."', INTERVAL 1 DAY) AND DATE_ADD('".$end."', INTERVAL 1 DAY)")->get();

		$json['stats'] = $statistics;


		if ($lccb->isEmpty()) {
			$json['average'] = [
				'status' => 'error',
				'title' => 'Error',
				'message' => 'Nothing was approved in this date range!'
			];

			return $json;
		}
		$total = 0;
		$count = 0;
		foreach ($lccb as $calculate) {
			//echo $calculate->requested_on."<br>";
			$lccbDate = new Carbon($calculate->requested_on);
			foreach ($calculate->approvers as $approval) {
				$date[] = new Carbon($approval->created_at);
			}
			$max = $date[0]->max($date[1]);
			//$max = Carbon::parse('2015-08-10');
			$diff = $max->diffInSeconds($lccbDate);
			$total += $diff;
			$count++;
			unset($date);
		}
		//echo "total time: ".$total;
		//echo "total count: ".$count;
		$time = $total / $count;

		$days = floor($time / (60 * 60 * 24));
		$time -= $days * (60 * 60 * 24);

		$hours = floor($time / (60 * 60));
		$time -= $hours * (60 * 60);

		$minutes = floor($time / 60);
		$time -= $minutes * 60;

		$seconds = floor($time);
		$time -= $seconds;

		$json['average'] = array(
			'status' => 'success',
			'message' => "<p class='lead'>{$days}d {$hours}h {$minutes}m {$seconds}s</p>"
		);

		return ($json);
	}
}
