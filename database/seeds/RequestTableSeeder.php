<?php

use App\Approval;
use App\Area;
use App\Category;
use App\Equipment;
use App\Location;
use App\Organization;
use App\Request;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RequestTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('requests')->truncate();
		DB::table('approvals')->truncate();
		/*
		$faker = Faker::create();
		$e_ids = Equipment::all()->lists('id')->toArray();
		$f_ids = Area::all()->lists('id')->toArray();
		$c_ids = Category::all()->lists('id')->toArray();
		$l_ids = Location::all()->lists('id')->toArray();

		$impacts = array(
			'Very High',
			'Low',
			'Will drastically reduce productivity',
			'No impact',
			'Medium',
			'Somewhat low, maybe medium',
			'Impacts critical path tools',
			'High impact',
			'High',
			'Moderate impact to low hanging fruit',
			'Looks like this will have some kind of impact to things...'
		);

		foreach (range(1, 50) as $index) {
			if ($faker->boolean(75)) {
				$status = 1;
			} elseif($faker->boolean(75)) {
				$status = 2;
			} elseif($faker->boolean(50)){
				$status = 5;
			} else {
				$status = 3;
			}
			$user_id = $faker->numberBetween(1,101);
			$user = User::with('organization')->findOrFail($user_id);
			$request = Request::create([
				'submitted_by' => $user_id,
				'functional_id' => $faker->randomElement($f_ids),
				'location_id' => $faker->randomElement($l_ids),
				'category_id' => $faker->randomElement($c_ids),
				'equipment_id' => $faker->randomElement($e_ids),
				'schedule_impact' => $faker->randomElement($impacts),
				'requester_name' => $user->name,
				'status' => $status,
				'cost_rom' => $faker->numberBetween(10000, 30000000),
				'description' => $faker->realText(500, 2),
				'business_need' => $faker->realText(500, 2),
				'if_not_done' => $faker->realText(500, 2),
				'alternatives' => $faker->realText(500, 2),
				'requested_on' => $faker->dateTimeBetween('-1 month', 'now')
			]);

			if($status == 5){
				$one = $faker->numberBetween(1,101);
				$two = $faker->numberBetween(1,101);
				$user1 = User::with('organization')->find($one);
				$user2 = User::with('organization')->find($two);
				Approval::create([
					'request_id' => $request->id,
					'user_id' => $user1->id,
					'organization_id' => $user1->organization->id,
					'choice' => 'Approve'
				]);
				Approval::create([
					'request_id' => $request->id,
					'user_id' => $user2->id,
					'organization_id' => $user2->organization->id,
					'choice' => 'Approve'
				]);
			}

			if($status == 2){
				$one = $faker->numberBetween(1,101);
				$user1 = User::with('organization')->find($one);
				if($faker->boolean(75)){
					Approval::create([
						'request_id' => $request->id,
						'user_id' => $user1->id,
						'organization_id' => $user1->organization->id,
						'choice' => 'Approve'
					]);
				} else {
					Approval::create([
						'request_id' => $request->id,
						'user_id' => $user1->id,
						'organization_id' => $user1->organization->id,
						'choice' => 'Reject'
					]);
				}

			}
		}
		*/
	}
}