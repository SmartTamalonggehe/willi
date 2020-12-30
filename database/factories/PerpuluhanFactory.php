<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Perpuluhan;
use Faker\Generator as Faker;

$factory->define(Perpuluhan::class, function (Faker $faker) {
    return [
        'transaksi_id' => 7,
        'nm_jemaat' => $faker->name(),
        'jumlah' => $faker->numberBetween($min = 50000, $max = 10000000),
        'tgl_perpuluhan' => $faker->dateTimeBetween('-1 years', 'now'),
    ];
});
