<?php

use App\Constants\StatusType;
use App\Data\Entities\Models\User\User;
use Faker\Generator as Faker;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(
    User::class,
    function (Faker $faker) {
        return [
            'username'       => $faker->unique()->userName,
            'email'          => $faker->unique()->safeEmail,
            'password'       => 'secret',
            'remember_token' => str_random(10),
            'full_name'      => [
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
            ],
            'is_first_login' => $faker->boolean,
            'status'         => $faker->randomElement(StatusType::getUserStatus()),
        ];
    }
);

$factory->state(
    User::class,
    'super_admin',
    function () {
        return [
            'email'          => 'admin@admin.com',
            'username'       => 'admin',
            'password'       => 'password',
            'full_name'      => [
                'first_name' => 'Admin',
                'last_name'  => 'inistrator',
            ],
            'is_first_login' => false,
            'status'         => StatusType::VERIFIED,
        ];
    }
);
