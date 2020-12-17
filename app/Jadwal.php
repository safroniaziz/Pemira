<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'tahun','jadwal_detail','status_jadwal','waktu_awal','waktu_akhir'
    ];
}
