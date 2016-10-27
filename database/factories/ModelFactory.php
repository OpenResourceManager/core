<?php

use App\Http\Models\API\Duty;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Http\Models\API\Duty::class, function (Faker\Generator $faker) {

    $word = $faker->unique()->word;

    return [
        'code' => strtoupper($word),
        'label' => ucfirst($word)
    ];
});

$factory->define(App\Http\Models\API\Account::class, function (Faker\Generator $faker) {
    $dutyIds = Duty::pluck('id')->all();
    return [
        'identifier' => strval($faker->unique()->randomNumber($nbDigits = 7, $strict = true)),
        'name_prefix' => $faker->optional()->title,
        'name_first' => $faker->firstName,
        'name_middle' => $faker->optional()->firstName,
        'name_last' => $faker->lastName,
        'name_postfix' => $faker->optional()->title,
        'name_phonetic' => $faker->optional()->firstName,
        'username' => $faker->unique()->userName,
        'primary_duty' => $faker->randomElement($dutyIds),
        'waiting_for_password' => $faker->boolean()
    ];
});