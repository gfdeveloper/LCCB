<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('roles')->truncate();
        Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator',
            'description' => 'This person rules the roost'
        ]);

        Role::create([
            'name' => 'approver',
            'display_name' => 'Approver',
            'description' => 'User can approve or disapprove requests but can not make system changes.'
        ]);
  
        Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'Default role for everyone. Can submit new requests but that\'s it'
        ]);

    }
}
