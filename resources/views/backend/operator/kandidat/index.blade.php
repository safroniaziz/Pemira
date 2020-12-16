<?php 
    use App\KandidatWakilKetua;
?>
@extends('layouts.backend')
@section('location','Dashboard')

@section('location2')
    <i class="fa fa-dashboard"></i>&nbsp;KANDIDAT
@endsection
@section('user-login','Operator')
@section('sidebar-menu')
    @include('backend/operator/sidebar')
@endsection
@section('content')
    <div class="callout callout-info ">
        <h4>Perhatian!</h4>
        <p>
            Berikut adalah data kandidat yang sudah terdaftar, silahkan tambahkan jika ada kandidat baru
            <br>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Manajemen Data Kandidat</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('operator.kandidat.add') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp; Tambah Baru</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="fa fa-success-circle"></i><strong>Berhasil :</strong> {{ $message }}
                        </div>
                    @endif
                    @if($message2 = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="fa fa-close"></i><strong>Gagal :</strong> {{ $message2 }}
                        </div>
                    @endif
                    <table class="table table-bordered table-hover" id="kelas">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Ketua</th>
                                <th>NPM Ketua</th>
                                <th>Prodi Ketua</th>
                                <th>Jenjang Prodi Ketua</th>
                                <th>Lengkapi Data Kandidat</th>
                                <th>Status Kandidat</th>
                                <th>Banner Kandidat</th>
                                <th>Ubah Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($kandidats as $kandidat)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $kandidat->nm_lengkap }}</td>
                                    <td>{{ $kandidat->npm }}</td>
                                    <td>{{ $kandidat->prodi }}</td>
                                    <td>
                                        @if ($kandidat->jenjang_prodi == "d1")
                                            Diploma 1
                                            @elseif($kandidat->jenjang_prodi == "d2")
                                            Diploma 2
                                            @elseif($kandidat->jenjang_prodi == "d3")
                                            Diploma 3
                                            @elseif($kandidat->jenjang_prodi == "d4")
                                            Diploma 4
                                            @elseif($kandidat->jenjang_prodi == "s1")
                                            Strata 1
                                            @elseif($kandidat->jenjang_prodi == "s2")
                                            Strata 2
                                        @endif
                                    </td>
                                    <td>
                                        <?php 
                                            $status = KandidatWakilKetua::where('kandidat_ketuas_id',$kandidat->id)->first();    
                                        ?>
                                        @if (empty($status))
                                            <a href="{{ route('operator.kandidat.add_detail',[$kandidat->id,$kandidat->slug]) }}" class="btn btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; Lengkapi Data Kandidat</a>
                                            @else
                                            <a disabled class="btn btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; Lengkapi Data Kandidat</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($kandidat->status_kandidat == "1")
                                            <label for="" class="label label-primary"><i class="fa fa-check-circle"></i>&nbsp;Aktif</label>
                                            @else
                                            <label for="" class="label label-danger"><i class="fa fa-thumbs-up"></i>&nbsp;Tidak Aktif</label>
                                        @endif
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/'.$kandidat->banner) }}" style="height: 100px;" alt="fp" class="img-responsive">
                                    </td>
                                    <td>
                                        <a href="{{ route('operator.kandidat.edit',[$kandidat->id, $kandidat->slug]) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>&nbsp;</a>
                                    </td>
                                    <div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-list"></i>&nbsp;Tambah Data Kelas Baru
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h5>
                                            </div>
                                            <form action=" {{ route('operator.kandidat.update') }} " method="POST">
                                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" id="id_edit">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Nama Transaksi</label>
                                                            <input type="text" name="nm_transaksi" id="nm_transaksi" class="form-control @error('nm_transaksi') is-invalid @enderror" placeholder="masukan Kandidat">
                                                            @if ($errors->has('nm_transaksi'))
                                                                <small class="form-text text-danger">{{ $errors->first('nm_transaksi') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Kandidat</label>
                                                            <select name="jenis_transaksi" id="jenis_transaksi" class="form-control @error('jenis_transaksi') is-invalid @enderror" id="">
                                                                <option disabled selected>-- pilih Kandidat --</option>
                                                                <option value="masuk">Transaksi Masuk</option>
                                                                <option value="keluar">Transaksi Keluar</option>
                                                            </select>
                                                            @if ($errors->has('jenis_transaksi'))
                                                                <small class="form-text text-danger">{{ $errors->first('jenis_transaksi') }}</small>
                                                            @endif
                                                        </div>
                
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>&nbsp;Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
                 </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready( function () {
            $('#kelas').DataTable();
        } );
    </script>
@endpush