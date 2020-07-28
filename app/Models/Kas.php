<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $table="kas";
    protected $guarded=[];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
