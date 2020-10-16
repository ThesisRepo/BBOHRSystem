<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456789')
    ];
});

$factory->afterCreating(User::class, function ($user, $faker) {
    $user->roles()->attach(1);
});

$factory->afterCreating(User::class, function ($user, $faker) {
    $user->userInformation()->create([
        'department_id' => 1,
        'company_number' => $faker->randomNumber(6),
        'company_position' => 'employee',
        'date_hired' => new Carbon('2016-01-23'),
        'contact_number' => $faker->phoneNumber,
        'civil_status' => 'single',
        'company_status' => 'regular',
        'birthday' => new Carbon('2016-01-23'),
        'address' => $faker->address,
        'tin_number' => $faker->randomNumber(6),
        'sss_number' => $faker->randomNumber(6),
        'pag_ibig_number' => $faker->randomNumber(6),
        'philhealth_number' => $faker->randomNumber(6),
        'allowed_leave_number' => $faker->unique()->numberBetween(1,10)
    ]);
});

