<?php

namespace App\Http\Controllers;


use App\Approval;

class SneakController extends Controller
{
	public function updateStatues()
	{
		$approvedList = Approval::groupBy('request_id')->havingRaw("COUNT(*) > 1")->get();

		dd($approvedList);
	}
}