<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perpuluhan extends Model
{
    protected $table = "perpuluhan";
    protected $guarded = [];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
