<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $jadwals = Jadwal::all();
        return view('backend/operator/jadwal.index',compact('jadwals'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'jadwal_detail' =>  'required',
            'waktu_awal' =>  'required',
            'waktu_akhir' =>  'required',
        ]);

        Jadwal::create([
            'tahun' =>  Carbon::createFromFormat('Y-m-d', $request->jadwal_detail)->year,
            'jadwal_detail' =>  $request->jadwal_detail,
            'waktu_awal' =>  $request->waktu_awal,
            'waktu_akhir' =>  $request->waktu_akhir,
        ]);

        return redirect()->route('operator.jadwal')->with(['success'    =>  'Jadwal Pemira Berhasil Ditambahkan !!']);
    }

    public function aktifkanStatus($id){
        Jadwal::where('id','!=',$id)->update([
            'status_jadwal'    =>  '0'
        ]);
        Jadwal::where('id',$id)->update([
            'status_jadwal'    =>  '1'
        ]);
        return redirect()->route('operator.jadwal')->with(['success' =>  'Jadwal Pemira Berhasil Di Aktifkan !!']);
    }

    public function delete(Request $request){
        $jadwal = Jadwal::where('id',$request->id)->delete();
        return redirect()->route('operator.jadwal')->with(['success' =>  'Jadwal Pemira Berhasil Di Hapus !!']);
    }
}
