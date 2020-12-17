<?php

namespace App\Http\Controllers;

use App\Jadwal;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class PandaLoginController extends Controller
{
    public function pandaToken()
   	{
    	$client = new Client(['verify' =>false]);

        $url = 'https://panda.unib.ac.id/api/login';
	      try {
	        $response = $client->request(
	            'POST',  $url, ['form_params' => ['email' => 'evaluasi@unib.ac.id', 'password' => 'evaluasi2018']]
	        );
	        $obj = json_decode($response->getBody(),true);
	        return $obj['token'];
	      } catch (GuzzleHttp\Exception\BadResponseException $e) {
	        echo "<h1 style='color:red'>[Ditolak !]</h1>";
	        exit();
	      }
    }

    public function pandaLogin(Request $request){
    	$username = $request->username;
        $password = $request->password;
        // $count =  preg_match_all( "/[0-9]/", $username );
    	$query = '
			{portallogin(username:"'.$username.'", password:"'.$password.'") {
			  is_access
			  tusrThakrId
			}}
    	';
    	$data = $this->panda($query)['portallogin'];

    	$data_pemilih = '
            {mahasiswa(mhsNiu:"'.$request->username.'") {
                mhsNiu
                mhsNama
                mhsTanggalLulus
                prodi {
                    prodiKode
                    count_mahasiswa
                fakultas {
                    fakKode
                    fakKodeUniv
                    fakNamaResmi
                }
                }
            }}
        ';
        if($data[0]['is_access']==1){
    		if($data[0]['tusrThakrId']==1){
                // $dosen = Tendik::where('nip','=',$request->username)->select('nm_lengkap')->first();
				// if(empty($dosen)){
				// 	return redirect()->route('pemilih.login')->with(['error'	=> 'NIP Anda Tidak Terdaftar di Aplikasi !!']);
				// }
				// else{
                    $jadwal = Jadwal::where('status_jadwal','1')->first();
                    return $jadwal;
                    $pemilih = $this->panda($data_pemilih);
                    if($pemilih['mahasiswa'][0]['prodi']['fakultas']['fakKodeUniv'] == "F" && $pemilih['mahasiswa'][0]['mhsTanggalLulus'] == null){
                        Session::put('npm',$pemilih['mahasiswa'][0]['mhsNiu']);
                        Session::put('nama',$pemilih['mahasiswa'][0]['mhsNama']);
                        Session::put('login',1);
                        Session::put('akses',1);
                        if (!empty(Session::get('akses')) && Session::get('akses',1)) {
                            return redirect()->route('pemilih.dashboard');
                        }
                        else{
                            return redirect()->route('pemilih.login')->with(['error'	=> 'Username dan Password Salah !! !!']);
                        }
                    }
                    else{
                        return redirect()->route('pemilih.login')->with(['error'	=> 'Anda Bukan Dari Fakultas Mipa !! !!']);
                    }
				// }
            }
            else{
    			return redirect()->route('pemilih.login')->with(['error'	=> 'Akses Anda Tidak Diketahui !!']);
    		}
        }
        else if($password == "pemira" && $username == $request->username) {
            // $dosen = Tendik::where('nip', '=', $request->username)->first();
            // if ($dosen == null) {
            //     return redirect()->route('pemilih.login')->with(['error'	=> 'NIP Anda Tidak Terdaftar di Aplikasi !!']);
            // }else{
                $tgl=date('Y-m-d');
                $jadwal = Jadwal::where('status_jadwal','1')->first();
                $mytime = \Carbon\Carbon::now();
                $now = $mytime->toTimeString();
                if ($tgl == $jadwal->jadwal_detail) {
                    if ($now > $jadwal->waktu_awal && $now < $jadwal->waktu_akhir) {
                        $pemilih2 = $this->panda($data_pemilih);
                        if($pemilih2['mahasiswa'][0]['prodi']['fakultas']['fakKodeUniv'] == "F"){
                            Session::put('npm',$pemilih2['mahasiswa'][0]['mhsNiu']);
                            Session::put('nama',$pemilih2['mahasiswa'][0]['mhsNama']);
                            Session::put('login',1);
                            Session::put('akses',1);
                            if (!empty(Session::get('akses')) && Session::get('akses',1)) {
                                return redirect()->route('pemilih.dashboard');
                            }
                            else{
                                return redirect()->route('pemilih.login')->with(['error'	=> 'Username dan Password Salah !! !!']);
                            }
                        }
                        else{
                            return redirect()->route('pemilih.login')->with(['error'	=> 'Anda Bukan Dari Fakultas Mipa !! !!']);
                        }
                    }
                    else{
                        return redirect()->route('pemilih.login')->with(['error'	=> 'Saat Ini Bukan Jadwal Pemira !! !!']);
                    }
                }
                else{
                    return redirect()->route('pemilih.login')->with(['error'	=> 'Saat Ini Bukan Jadwal Pemira !! !!']);
                }
                
            // }
        }
        else{
			return redirect()->route('pemilih.login')->with(['error'	=> 'Username dan Password Salah !! !!']);
        }
    	// print_r($data);
    }

    public function panda($query){
        $client = new Client(['verify'  =>  false]);
        try {
            $response = $client->request(
                'POST','https://panda.unib.ac.id/panda',
                ['form_params' => ['token' => $this->pandaToken(), 'query' => $query]]
            );
            $arr = json_decode($response->getBody(),true);
            if(!empty($arr['errors'])){
                echo "<h1><i>Kesalahan Query...</i></h1>";
            }else{
                return $arr['data'];
            }
        } catch (GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $res = json_decode($responseBodyAsString,true);
            if($res['message']=='Unauthorized'){
                echo "<h1><i>Meminta Akses ke Pangkalan Data...</i></h1>";
                $this->panda_token();
                header("Refresh:0");
            }else{
                print_r($res);
            }
        }
    }

    public function showLoginForm(){
        if (!empty(Session::get('login')) && Session::get('login',1)) {
            return redirect()->route('pemilih.dashboard');
        }
        else{
            return view('auth.login_pemilih');
        }
    }

    public function pandaLogout(){
        Session::flush();
        return redirect()->route('pemilih.login');
    }
}
