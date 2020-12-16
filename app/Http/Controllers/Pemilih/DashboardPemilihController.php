<?php

namespace App\Http\Controllers\Pemilih;

use App\Http\Controllers\Controller;
use App\KandidatKetua;
use App\KandidatWakilKetua;
use App\Http\Controllers\PandaLoginController;
use App\Jadwal;
use App\Rekapitulasi;
use Session;
use Illuminate\Http\Request;

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

    public function pemilihPost(Request $request, $id){
        $sesi = Session::get('akses');
        if(Session::get('login') && Session::get('login',1) && Session::get('akses',1)){
            if($sesi == 1){
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

                return redirect()->route('pemilih.dashboard')->with(['success' =>  'Pilihan anda sudah disimpan !!']);
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
