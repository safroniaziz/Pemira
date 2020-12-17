<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Jadwal;
use App\KandidatKetua;
use App\Rekapitulasi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardOperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(){
        $datas = Rekapitulasi::leftJoin('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.no_urut',DB::raw('COUNT(rekapitulasis.id) as jumlah'))
                                ->groupBy('kandidat_ketuas.id')
                                ->get();
        $jadwal_detail = Jadwal::where('status_jadwal','1')->select('jadwal_detail')->first();
        $waktu = Jadwal::where('status_jadwal','1')->first();
        $kandidat = Count(KandidatKetua::where('status_kandidat','1')->get());
        return view('backend/operator.dashboard',compact('datas','jadwal_detail','waktu','kandidat'));
    }
}