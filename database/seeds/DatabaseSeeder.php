<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
	    DB::statement("SET foreign_key_checks=0");

        $this->call('PermissionsTableSeeder');
        $this->command->info('Permissions table seeded!');
        $this->call('RolesTableSeeder');
        $this->command->info('Roles table seeded!');
        $this->call('OrganizationTableSeeder');
        $this->command->info('Organization table seeded!');
        $this->call('UserTableSeeder');
        $this->command->info('User table seeded!');
	    $this->call('EquipmentTableSeeder');
	    $this->command->info('Equipment table seeded!');
	    $this->call('RandomTableSeeder');
	    $this->command->info('All other tables seeded!');
	    $this->call('RequestTableSeeder');
	    $this->command->info('Made Some Requests!');
	    DB::statement("SET foreign_key_checks=1");
        Model::reguard();
    }
}
