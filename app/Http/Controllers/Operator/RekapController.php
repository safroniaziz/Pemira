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
                                ->orderBy('no_urut')
                                ->get();
        return view('backend/operator/laporan.keseluruhan',compact('laporans','grafiks'));
    }

    public function laporanPerProdi(){
        $angkatans = Rekapitulasi::select('angkatan_pemilih')
                                ->groupBy('angkatan_pemilih')
                                ->orderBy('angkatan_pemilih')
                                ->get();
        return view('backend/operator/laporan.per_prodi',compact('angkatans'));
    }

    public function cariProdi(){
        if (isset($_POST['prodi']) && isset($_POST['angkatan'])) {
            if ($_POST['angkatan'] == "semua") {
                $laporans = Rekapitulasi::join('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->join('kandidat_wakil_ketuas','kandidat_wakil_ketuas.kandidat_ketuas_id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.nm_lengkap as nm_ketua','kandidat_wakil_ketuas.nm_lengkap as nm_wakil','prodi_pemilih','no_urut','npm_pemilih','angkatan_pemilih')
                                ->where('npm_pemilih', 'like', '%' . $_POST['prodi'] . '%')
                                ->get();
                $grafiks = Rekapitulasi::leftJoin('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.no_urut',DB::raw('COUNT(rekapitulasis.id) as jumlah'))
                                ->groupBy('kandidat_ketuas.id')
                                ->where('npm_pemilih', 'like', '%' . $_POST['prodi'] . '%')
                                ->orderBy('no_urut')
                                ->get();
                $angkatans = Rekapitulasi::select('angkatan_pemilih')
                                ->groupBy('angkatan_pemilih')
                                ->orderBy('angkatan_pemilih')
                                ->get();
                $prodi = Rekapitulasi::where('npm_pemilih', 'like', '%' . $_POST['prodi'] . '%')->select('prodi_pemilih','jenjang')->first();
                return view('backend/operator/laporan.per_prodi',compact('laporans','grafiks','angkatans'))->with('success','Menampilkan Laporan Program Studi "'.$prodi->jenjang.' '.$prodi->prodi_pemilih.'" Di Semua Angkatan');;
            }
            else{
                $laporans = Rekapitulasi::join('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->join('kandidat_wakil_ketuas','kandidat_wakil_ketuas.kandidat_ketuas_id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.nm_lengkap as nm_ketua','kandidat_wakil_ketuas.nm_lengkap as nm_wakil','prodi_pemilih','no_urut','npm_pemilih','angkatan_pemilih')
                                ->where('npm_pemilih', 'like', '%' . $_POST['prodi'] . '%')
                                ->where('angkatan_pemilih',$_POST['angkatan'])
                                ->get();
                $grafiks = Rekapitulasi::leftJoin('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.no_urut',DB::raw('COUNT(rekapitulasis.id) as jumlah'))
                                ->groupBy('kandidat_ketuas.id')
                                ->where('npm_pemilih', 'like', '%' . $_POST['prodi'] . '%')
                                ->where('angkatan_pemilih',$_POST['angkatan'])
                                ->orderBy('no_urut')
                                ->get();
                $angkatans = Rekapitulasi::select('angkatan_pemilih')
                                ->groupBy('angkatan_pemilih')
                                ->orderBy('angkatan_pemilih')
                                ->get();
                $prodi = Rekapitulasi::where('npm_pemilih', 'like', '%' . $_POST['prodi'] . '%')->where('angkatan_pemilih',$_POST['angkatan'])->select('prodi_pemilih','jenjang','angkatan_pemilih')->first();
                return view('backend/operator/laporan.per_prodi',compact('laporans','grafiks','angkatans'))->with('success','Menampilkan Laporan Program Studi "'.$prodi->jenjang.' '.$prodi->prodi_pemilih.'" Di Angkatan "'.$prodi->angkatan_pemilih.'" ');;;
            }
        }
        else{
            return redirect()->route('operator.laporan.prodi')->with(['error'   =>  'Harap Pilih Program Studi Terlebih Dahulu']);
        }
    }

    public function laporanPerAngkatan(){
        $angkatans = Rekapitulasi::select('angkatan_pemilih')
                                ->groupBy('angkatan_pemilih')
                                ->orderBy('angkatan_pemilih')
                                ->get();
        return view('backend/operator/laporan.per_angkatan',compact('angkatans'));
    }

    public function cariAngkatan(){
        if(isset($_POST['angkatan'])){
            $laporans = Rekapitulasi::join('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->join('kandidat_wakil_ketuas','kandidat_wakil_ketuas.kandidat_ketuas_id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.nm_lengkap as nm_ketua','kandidat_wakil_ketuas.nm_lengkap as nm_wakil','prodi_pemilih','no_urut','npm_pemilih','angkatan_pemilih')
                                ->where('angkatan_pemilih',$_POST['angkatan'])
                                ->get();
                $grafiks = Rekapitulasi::leftJoin('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.no_urut',DB::raw('COUNT(rekapitulasis.id) as jumlah'))
                                ->groupBy('kandidat_ketuas.id')
                                ->where('angkatan_pemilih',$_POST['angkatan'])
                                ->orderBy('no_urut')
                                ->get();
                $angkatans = Rekapitulasi::select('angkatan_pemilih')
                                ->groupBy('angkatan_pemilih')
                                ->orderBy('angkatan_pemilih')
                                ->get();
                return view('backend/operator/laporan.per_angkatan',compact('laporans','grafiks','angkatans'))->with('success','Menampilkan Di Angkatan "'.$_POST['angkatan'].'" ');;;
        }
        else{
            return redirect()->route('operator.laporan.angkatan')->with(['error'   =>  'Harap Pilih Angkatan Terlebih Dahulu']);

        }
    }

    public function laporanPerJenjang(){
        return view('backend/operator/laporan.per_jenjang');
    }

    public function cariJenjang(){
        if(isset($_POST['jenjang'])){
            $laporans = Rekapitulasi::join('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->join('kandidat_wakil_ketuas','kandidat_wakil_ketuas.kandidat_ketuas_id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.nm_lengkap as nm_ketua','kandidat_wakil_ketuas.nm_lengkap as nm_wakil','prodi_pemilih','no_urut','npm_pemilih','angkatan_pemilih','jenjang')
                                ->where('jenjang',$_POST['jenjang'])
                                ->get();
                $grafiks = Rekapitulasi::leftJoin('kandidat_ketuas','kandidat_ketuas.id','rekapitulasis.kandidat_ketuas_id')
                                ->select('kandidat_ketuas.no_urut',DB::raw('COUNT(rekapitulasis.id) as jumlah'))
                                ->groupBy('kandidat_ketuas.id')
                                ->where('jenjang',$_POST['jenjang'])
                                ->orderBy('no_urut')
                                ->get();
                return view('backend/operator/laporan.per_jenjang',compact('laporans','grafiks'))->with('success','Menampilkan Di Jenjang "'.$_POST['jenjang'].'" ');;;
        }
        else{
            return redirect()->route('operator.laporan.jenjang')->with(['error'   =>  'Harap Pilih Jenjang Terlebih Dahulu']);

        }
    }
}
