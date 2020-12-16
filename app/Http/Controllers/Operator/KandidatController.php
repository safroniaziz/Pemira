<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PandaLoginController;
use App\Kandidat;
use App\KandidatKetua;
use App\KandidatWakilKetua;
use App\Misi;
use App\Visi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;

class KandidatController extends Controller
{
    public function index(){
        $kandidats = KandidatKetua::all();
        return view('backend/operator/kandidat.index',compact('kandidats'));
    }

    public function add(){
        $panda = new PandaLoginController();
        return view('backend/operator/kandidat.add');
    }

    public function post(Request $request){
        $this->validate($request,[
            'no_urut'   =>  'required',
            'nm_lengkap'   =>  'required',
            'npm'   =>  'required',
            'tanggal_lahir'   =>  'required',
            'jenis_kelamin'   =>  'required',
            'prodi'   =>  'required',
            'jenjang_prodi'   =>  'required',
            'telephone'   =>  'required',
            'banner'   =>  'required',
        ]);
        $slug_kandidat = Str::slug($request->nm_lengkap);

        $banner = $request->file('banner');
        $bannerUrl = $banner->store('banner/'.$slug_kandidat);
        KandidatKetua::create([
            'no_urut'   =>  $request->no_urut,
            'nm_lengkap'   =>  $request->nm_lengkap,
            'slug'          =>  Str::slug($request->nm_lengkap),
            'npm'   =>  $request->npm,
            'tanggal_lahir'   =>  $request->tanggal_lahir,
            'jenis_kelamin'   =>  $request->jenis_kelamin,
            'prodi'   =>  $request->prodi,
            'jenjang_prodi'   =>  $request->jenjang_prodi,
            'telephone'   =>  $request->telephone,
            'status_kandidat'   =>  '0',
            'banner'    =>  $bannerUrl,
        ]);

        return redirect()->route('operator.kandidat')->with(['success'  =>  'Data Berhasil Ditambahkab !!']);
    }

    public function addDetail($id ,$slug){
        return view('backend/operator/kandidat.add_detail',compact('id'));
    }

    public function detailPost(Request $request, $id){
        $this->validate($request,[
            'nm_lengkap'   =>  'required',
            'npm'   =>  'required',
            'tanggal_lahir'   =>  'required',
            'jenis_kelamin'   =>  'required',
            'prodi'   =>  'required',
            'jenjang_prodi'   =>  'required',
            'telephone'   =>  'required',
            'visi'  =>  'required',
            'misi'  =>  'required',

        ]);
        DB::beginTransaction();
        try {
            KandidatKetua::where('id',$id)->update([
                'status_kandidat'   =>  '1',
            ]);
            
            KandidatWakilKetua::create([
                'kandidat_ketuas_id'    =>  $id,
                'nm_lengkap'   =>  $request->nm_lengkap,
                'slug'          =>  Str::slug($request->nm_lengkap),
                'npm'   =>  $request->npm,
                'tanggal_lahir'   =>  $request->tanggal_lahir,
                'jenis_kelamin'   =>  $request->jenis_kelamin,
                'prodi'   =>  $request->prodi,
                'jenjang_prodi'   =>  $request->jenjang_prodi,
                'telephone'   =>  $request->telephone,
            ]);

            Visi::create([
                'kandidat_ketuas_id'    =>  $id,
                'visi'  =>  $request->visi,
            ]);

            Misi::create([
                'kandidat_ketuas_id'    =>  $id,
                'misi'  =>  $request->misi,
            ]);
            DB::commit();
            return redirect()->route('operator.kandidat')->with(['success' =>  'Data Kandidat berhasil ditambahkan !']);
        } catch (Exception $e) {
            // Rollback Transaction
            DB::rollback();
            // ada yang error
            return redirect()->route('operator.kandidat')->with(['error' =>  'Data Kandidat gagal ditambahkan !']);
        }
    }

    public function edit($id){
        $kandidat = KandidatKetua::where('id',$id)->get();
        $wakil    = KandidatWakilKetua::where('kandidat_ketuas_id',$id)->get();
        $visi       = Visi::where('kandidat_ketuas_id',$id)->get();
        $misi       = Misi::where('kandidat_ketuas_id',$id)->get();
        return view('backend/operator/kandidat.edit',compact('kandidat','wakil','visi','misi'));
    }
}
