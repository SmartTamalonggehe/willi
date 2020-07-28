<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Kas;
use App\Models\Transaksi;
use Faker\Generator as Faker;

$factory->define(Kas::class, function (Faker $faker) {
    return [
        'tgl_kas' => '2019-01-01',
        'transaksi_id' => Transaksi::inRandomOrder()->first()->id,
        'pemasukan' => 2000000,
        'pengeluaran' => 0,
        'saldo' => 2000000,
    ];
});
