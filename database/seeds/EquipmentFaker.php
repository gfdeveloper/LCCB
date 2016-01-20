<?php

namespace Database\Seeds;

use Faker\Factory as Faker;

class EquipmentFaker extends Faker{
	public function equipmentName()
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
			'BULK'
		);

		$endings = array(
			'SYSTEM',
			'CLEANING',
			'EXHAUST',
			'INTAKE'
		);

		return $this->generator->randomElement($buildings).' '.$this->generator->randomElement($stuff).' '.$this->generator->randomElement($endings);
	}
}