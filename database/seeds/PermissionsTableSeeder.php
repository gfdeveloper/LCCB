<?php

use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('permissions')->truncate();
        Permission::create([
            'name' => 'can-create-request',
            'display_name' => 'Can create request',
            'description' => 'Allows the user to submit a new request'
        ]);
        Permission::create([
            'name' => 'can-approve-request',
            'display_name' => 'Can approve request',
            'description' => 'User can approve submitted requests'
        ]);
        Permission::create([
            'name' => 'can-admin',
            'display_name' => 'Can Admin',
            'description' => 'User can so anything'
        ]);

    }
}
