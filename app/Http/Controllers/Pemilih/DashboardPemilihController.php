<?php

namespace App\Http\Controllers\Pemilih;

use App\Http\Controllers\Controller;
use App\KandidatKetua;
use App\KandidatWakilKetua;
use App\Http\Controllers\PandaLoginController;
use App\Jadwal;
use App\Rekapitulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardPemilihController extends Controller
{
    public function dashboard(){
        $sesi = Session::get('akses');
        if(Session::get('login') && Session::get('login',1) && Session::get('akses',1)){
            if($sesi == 1){
                $sudah = Rekapitulasi::where('npm_pemilih',Session::get('npm'))->get();
                $kandidats = KandidatWakilKetua::join('kandidat_ketuas','kandidat_ketuas.id','kandidat_wakil_ketuas.kandidat_ketuas_id')
                                        ->select('kandidat_ketuas.id','kandidat_ketuas.nm_lengkap as nm_ketua','kandidat_wakil_ketuas.nm_lengkap as nm_wakil','banner','no_urut','kandidat_ketuas.slug')
                                        ->get();
                return view('backend/pemilih.dashboard',compact('kandidats','sudah'));
            }   
            else{
                Session::flush();
                return redirect()->route('pemilih.login')->with(['error' => 'Anda Tidak Terdaftar']);
            }
        }
        else{
            return redirect()->route('pemilih.login')->with(['error' => 'Masukan Username dan Password Terlebih Dahulu !!']);
        }
    }

    public function pemilihPost($id){
        $sesi = Session::get('akses');
        if(Session::get('login') && Session::get('login',1) && Session::get('akses',1)){
            if($sesi == 1){
                DB::beginTransaction();
                try {
                    $sudah = Rekapitulasi::where('npm_pemilih',Session::get('npm'))->get();
                    $panda = new PandaLoginController();
                    $mahasiswa = '
                        {mahasiswa(mhsNiu:"'.Session::get('npm').'") {
                            mhsNiu
                            mhsNama
                            mhsAngkatan
                            mhsJenisKelamin
                            prodi {
                                prodiNamaResmi
                                prodiJjarKode
                                fakultas {
                                    fakNamaResmi
                                }
                            }
                        }}
                    ';
                    $mahasiswas = $panda->panda($mahasiswa);
                    $jadwal_aktif = Jadwal::where('status_jadwal','1')->first();
                    if (count($sudah) > 0) {
                        
                    }
                    else{
                        Rekapitulasi::create([
                            'kandidat_ketuas_id'    =>  $id, 
                            'jadwal_id' =>    $jadwal_aktif->id,
                            'npm_pemilih' =>    $mahasiswas['mahasiswa'][0]['mhsNiu'],  
                            'prodi_pemilih' =>  $mahasiswas['mahasiswa'][0]['prodi']['prodiNamaResmi'],  
                            'fakultas_pemilih' =>   $mahasiswas['mahasiswa'][0]['prodi']['fakultas']['fakNamaResmi'],  
                            'angkatan_pemilih' =>   $mahasiswas['mahasiswa'][0]['mhsAngkatan'],  
                            'jk_pemilik' =>     $mahasiswas['mahasiswa'][0]['mhsJenisKelamin'], 
                            'jenjang' =>     $mahasiswas['mahasiswa'][0]['prodi']['prodiJjarKode'], 
                        ]);
                    }
                    DB::commit();
                    return redirect()->route('pemilih.dashboard')->with(['success' =>  'Pilihan anda sudah disimpan !!']);
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->route('pemilih.dashboard')->with(['error' =>  'Pilihan anda gagal disimpan !!']);
                }
            }   
            else{
                Session::flush();
                return redirect()->route('pemilih.login')->with(['error' => 'Anda Tidak Terdaftar']);
            }
        }
        else{
            return redirect()->route('pemilih.login')->with(['error' => 'Masukan Username dan Password Terlebih Dahulu !!']);
        }
    }
}
