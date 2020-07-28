<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Transaksi;
use Faker\Generator as Faker;

$factory->define(Transaksi::class, function (Faker $faker) {
    return [
        'jenis_transaksi' => 'pemasukan',
        'nm_transaksi' => 'Perpuluhan',
    ];
});
