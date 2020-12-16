<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    protected $fillable = [
        'kandidat_ketuas_id','jadwal_id','npm_pemilih','prodi_pemilih','jenjang','fakultas_pemilih','angkatan_pemilih','jenis_kelamin'
    ];
}
