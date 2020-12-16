<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KandidatKetua extends Model
{
    protected $fillable = [
        'no_urut','nm_lengkap','npm','tanggal_lahir','jenis_kelamin','prodi','jenjang_prodi','telephone','visi','slug','banner'
    ];
}
