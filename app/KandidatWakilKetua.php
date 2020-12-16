<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KandidatWakilKetua extends Model
{
    protected $fillable = [
        'kandidat_ketuas_id','nm_lengkap','npm','tanggal_lahir','jenis_kelamin','prodi','telephone','slug','jenjang_prodi'
    ];
}
