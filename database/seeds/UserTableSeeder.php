<?php

use App\Organization;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->truncate();
	    DB::table('role_user')->truncate();
        $faker = Faker::create();
        $orgs = Organization::all()->lists('id')->toArray();
        User::create([
            'name' => 'Christopher Carver',
            'email' => 'christopher.carver@globalfoundries.com',
            'organization_id' => '1',
            'password' => bcrypt('3l1t3')
        ]);


		/*
        foreach(range(1,100) as $index) {
	        $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'organization_id' => $faker->randomElement($orgs),
                'password' => str_random(10),
                'remember_token' => str_random(10),
            ]);

	        $user->attachRole(3);
        }
		*/

	    User::find(1)->attachRole(1);
    }
}
