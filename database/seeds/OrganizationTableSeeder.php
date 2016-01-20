<?php

use App\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->truncate();
        $faker = Faker::create();
        Organization::create([
            'name' => 'GLOBALFOUNDRIES',
        ]);
        /*
        foreach(range(1,30) as $index) {
            Organization::create([
                'name' => $faker->company,
            ]);
        }
        */
    }
}
