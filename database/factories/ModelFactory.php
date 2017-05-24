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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Wallet::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words($nb = 3, $asText = true),
        'description' => $faker->text($maxNbChars = 190),
    ];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [
        'amount' => $faker->numerify('###.##'),
        'transaction_date' => $faker->date('Y-m-d'),
        'note' => $faker->text($maxNbChars = 190),
        'location' => $faker->streetAddress,
        'reminder_date' => $faker->date('Y-m-d'),
        'reportable'=> $faker->boolean,
    ];
});

/*
$factory->define(App\Currency::class, function (Faker\Generator $faker) {
    return [
        'country' => $faker->country,
        'code' => $faker->currencyCode,
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'type' => $faker->randomElement($array = array('income', 'expense')),
    ];
});
*/