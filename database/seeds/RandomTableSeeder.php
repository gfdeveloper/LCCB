<?php

use App\Area;
use App\Category;
use App\Location;
use App\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RandomTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('locations')->truncate();
		Location::create([
			'name' => 'Phase 1, Level 1'
		]);
		Location::create([
			'name' => 'Phase 1, Level 2'
		]);
		Location::create([
			'name' => 'Phase 1, Level 3'
		]);
		Location::create([
			'name' => 'Phase 2, Level 1'
		]);
		Location::create([
			'name' => 'Phase 2, Level 2'
		]);
		Location::create([
			'name' => 'Phase 2, Level 3'
		]);
		Location::create([
			'name' => 'Phase 3, Level 1'
		]);
		Location::create([
			'name' => 'Phase 3, Level 2'
		]);
		Location::create([
			'name' => 'Phase 3, Level 3'
		]);

		DB::table('areas')->truncate();

		Area::create([
			'name' => 'AME'
		]);
		Area::create([
			'name' => 'M&W'
		]);
		Area::create([
			'name' => 'Ramp'
		]);
		Area::create([
			'name' => 'SCI'
		]);
		Area::create([
			'name' => 'Tool Install'
		]);


		DB::table('categories')->truncate();

		Category::create([
			'name' => 'Spec Gas'
		]);
		Category::create([
			'name' => 'Electrical'
		]);
		Category::create([
			'name' => 'Base Build'
		]);
		Category::create([
			'name' => 'Design Request'
		]);
		Category::create([
			'name' => 'Layout Optimization'
		]);
		Category::create([
			'name' => 'Safety'
		]);

		DB::table('status')->truncate();

		Status::create([
			'name' => 'New',
			'slug' => 'new'
		]);
		Status::create([
			'name' => 'Open/Needs Further Review',
			'slug' => 'open-needs-further-review'
		]);
		Status::create([
			'name' => 'Waiting for Approval',
			'slug' => 'waiting-for-approval'
		]);
		Status::create([
			'name' => 'Rejected',
			'slug' => 'rejected'
		]);
		Status::create([
			'name' => 'Approved',
			'slug' => 'approved'
		]);
	}
}
