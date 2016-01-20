<?php

use App\Equipment;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EquipmentTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$buildings = array(
			'FAB',
			'CUB A',
			'CUB B',
			'CUB C',
			'PHASE 2',
			'PHASE 3'
		);

		$stuff = array(
			'ELECTRICAL',
			'HEATER',
			'PROTECTION',
			'FUEL OIL',
			'CHILLER',
			'VACUUM',
			'GEEX',
			'AMEX',
			'RAW WATER',
			'UPW',
			'PCW',
			'SLURRY',
			'HPM',
			'BULK',
			'RECIRC'
		);

		$endings = array(
			'SYSTEM',
			'CLEANING',
			'EXHAUST',
			'INTAKE',
			'CONTROLS',
			'FREEZER',
			'UNIT',
			'DOCK'
		);

		$tools = array(
			'APA',
			'APC',
			'APR',
			'CVD',
			'EPI',
			'FVX',
			'PCL',
			'BFI',
			'ETX',
			'SCB',
			'CSS',
			'LSA',
			'PSX',
			'IMP',
			'SNK',
			'MET',
			'OPI'
		);

		$bcodes = array(
			'FA',
			'FB',
			'FC',
			'FD'
		);

		$level = array(
			'1',
			'2',
			'3',
			'4'
		);

		$mainSystem = array(
			'A',
			'B',
			'C',
			'D',
			'E',
			'F',
			'G',
			'P',
			'S',
			'T',
			'V',
			'W',
			'X',
			'Z'
		);

		$system = array(
			'RCCU',
			'RCAC',
			'RCAH',
			'RAIR',
			'REFG',
			'CRAC',
			'CTWS',
			'CTWR',
			'CWSO',
			'CWRO',
			'CWS1',
			'CHWS',
			'CHWR',
			'HSSO',
			'HSRO',
			'HRSO',
			'HRRO',
			'MUA0',
			'MUA1',
			'MUA2',
			'FA00',
			'PCSO',
			'VARO',
			'VVOO',
			'VVOR',
			'VVPO',
			'VVPR',
			'VVSO',
			'VVSO',
			'VVSR',
			'FFU0',
			'FFU1',
			'FFU2',
			'FFU3',
			'FFU4',
			'FFU5',
			'FCU1',
			'FCU2',
			'FCU3',
			'FCU4',
			'CUH1',
			'CUH2',
			'CUH3',
			'CUH4',
			'UH01',
			'UH02',
			'UH03',
			'UH04',
			'PCW0',
			'PCW1',
			'PCW2',
			'PCWR',
			'PCWS',
			'PCTS',
			'PCTR',
			'CPSS',
			'CPSA',
			'CPSB',
			'CPSC',
			'CPSD',
			'CPSE',
			'CPSF',
			'CPSG',
			'CPSH',
			'CPSI',
			'CPSJ',
			'CPSK',
			'CPSL',
			'CPSM',
			'CPSN',
			'CPSO',
			'CPSP',
			'CPSQ',
		);

		//$users = User::all()->lists('id')->toArray();
		DB::table('equipment')->truncate();
		//$faker = Faker::create();
		//$faker->addProvider(new Database\Seeds\EquipmentFaker($faker));
		/*
		foreach(range(1,1000) as $index) {
			if($faker->boolean(75)) {
				$name = $faker->randomElement($tools).$faker->unique()->numberBetween(1000,99999);
			} elseif($faker->boolean(95)) {
				$name = $faker->randomElement($bcodes).
					$faker->randomElement($level).
					$faker->randomElement($mainSystem).
					$faker->randomElement($system).
					$faker->randomElement($mainSystem).
					$faker->numberBetween(123,999);
			} else {
				$name = $faker->randomElement($buildings).' '.$faker->randomElement($stuff).' '.$faker->randomElement($endings);
			}
			Equipment::create([
				'name' => $name,
				'user_id' => $faker->randomElement($users)
			]);
		}
		*/
	}
}
