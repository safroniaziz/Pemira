<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Rekapitulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function laporanKeseluruhan(){
        $laporans = Rekapitulasi::join('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->join('kandidat_wakil_ketuas','kandidat_wakil_ketuas.kandidat_ketuas_id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.nm_lengkap as nm_ketua','kandidat_wakil_ketuas.nm_lengkap as nm_wakil','prodi_pemilih','no_urut','npm_pemilih','angkatan_pemilih')
                                ->get();
        $grafiks = Rekapitulasi::leftJoin('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.no_urut',DB::raw('COUNT(rekapitulasis.id) as jumlah'))
                                ->groupBy('kandidat_ketuas.id')
                                ->get();
        return view('backend/operator/laporan.keseluruhan',compact('laporans','grafiks'));
    }

    public function laporanPerProdi(){
        $grafiks = Rekapitulasi::leftJoin('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.no_urut',DB::raw('COUNT(rekapitulasis.id) as jumlah'))
                                ->groupBy('kandidat_ketuas.id')
                                ->where('prodi_pemilih','')
                                ->get();
        return view('backend/operator/laporan.per_prodi',compact('laporans','grafiks'));
    }
}
