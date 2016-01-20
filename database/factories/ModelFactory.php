<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Organization;

$factory->define('App\User', function ($faker) {
    $orgs = Organization::all()->lists('id');
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'organization_id' => $faker->randomElement($orgs),
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define('App\Request', function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define('App\Organization', function ($faker) {
    return [
        'name' => $faker->company,
    ];
});
