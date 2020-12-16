@extends('layouts.backend')
@section('location','Dashboard')
@section('location2')
    <i class="fa fa-dashboard"></i>&nbsp;TAMBAH KANDIDAT
@endsection
@section('user-login','Operator')
@section('sidebar-menu')
    @include('backend/operator/sidebar')
@endsection
@section('content')
    <div class="callout callout-info text-center">
        <h4>Perhatian!</h4>
        <p>
            Saat anda menambahkan data kandidat baru, status kandidat adalah tidak aktif, untuk mengaktifkan status, silahkan lengkapi data dengan mengklik tombol lengkapi data terlebih dahulu !!
            <br>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-tools pull-left">
                        <a href="{{ route('operator.kandidat') }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form action="{{ route('operator.kandidat.post') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Nomor Urut</label>
                                <input type="number" name="no_urut" class="form-control">
                                @if ($errors->has('no_urut'))
                                    <small class="form-text text-danger">{{ $errors->first('no_urut') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Nama Lengkap Ketua</label>
                                <input type="text" name="nm_lengkap" class="form-control">
                                @if ($errors->has('nm_lengkap'))
                                    <small class="form-text text-danger">{{ $errors->first('nm_lengkap') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Nomor Pokok Mahasiswa (NPM) Ketua</label>
                                <input type="text" name="npm" class="form-control">
                                @if ($errors->has('npm'))
                                    <small class="form-text text-danger">{{ $errors->first('npm') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Tanggal Lahir Ketua</label>
                                <input type="date" name="tanggal_lahir" class="form-control">
                                @if ($errors->has('tanggal_lahir'))
                                    <small class="form-text text-danger">{{ $errors->first('tanggal_lahir') }}</small>
                                @endif
                            </div>
                         
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Jenis Kelamin Ketua</label>
                                <select name="jenis_kelamin" class="form-control" id="">
                                    <option disabled selected>-- pilih jenis kelamin --</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                @if ($errors->has('jenis_kelamin'))
                                    <small class="form-text text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Program Studi Ketua</label>
                                <input type="text" name="prodi" class="form-control">
                                @if ($errors->has('prodi'))
                                    <small class="form-text text-danger">{{ $errors->first('prodi') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Jenjang Program Studi Ketua</label>
                                <select name="jenjang_prodi" class="form-control" id="">
                                    <option disabled selected>-- pilih jenjang prodi --</option>
                                    <option value="d1">Diploma 1</option>
                                    <option value="d2">Diploma 2</option>
                                    <option value="d3">Diploma 3</option>
                                    <option value="d4">Diploma 3</option>
                                    <option value="s1">Strata 1</option>
                                    <option value="s2">Strata 2</option>
                                </select>
                                @if ($errors->has('jenjang_prodi'))
                                    <small class="form-text text-danger">{{ $errors->first('jenjang_prodi') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Telephone Ketua</label>
                                <input type="text" name="telephone" class="form-control">
                                @if ($errors->has('telephone'))
                                    <small class="form-text text-danger">{{ $errors->first('telephone') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Banner Kandidat</label>
                                <input type="file" name="banner" class="form-control">
                                @if ($errors->has('banner'))
                                    <small class="form-text text-danger">{{ $errors->first('banner') }}</small>
                                @endif
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <button type="reset" name="reset" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                                <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                            </div>
                        </form>
                    </div>
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

        $('#tahun_transaksi').each(function() {
            var year = (new Date()).getFullYear();
            var current = year;
            year -= 3;
            for (var i = 0; i < 6; i++) {
            if ((year+i) == current)
                $(this).append('<option selected value="' + (year + i) + '">' + (year + i) + '</option>');
            else
                $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
            }
        });
    </script>
@endpush