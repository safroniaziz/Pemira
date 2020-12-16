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
            Berikut adalah data anggota yang sudah tersedia, silahkan tambahkan jika ada anggota baru
            <br>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Manajemen Data Anggota</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaltambah">
                            <i class="fa fa-plus"></i>&nbsp;Tambah Baru
                        </button>

                        <!-- Modal Tambah -->
                        <div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-list"></i>&nbsp;Tambah Data Jadwal Pemira
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                </div>
                                <form action=" {{ route('operator.jadwal.post') }} " method="POST">
                                    {{ csrf_field() }} {{ method_field('POST') }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Pilih Jadwal Pemira</label>
                                                <input type="date" name="jadwal_detail" class="form-control @error('jadwal_detail') is-invalid @enderror" placeholder="masukan jenis transaksi">
                                                @if ($errors->has('jadwal_detail'))
                                                    <small class="form-text text-danger">{{ $errors->first('jadwal_detail') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                                            <button type="submit" class="btn btn-primary" id="btn-submit"><i class="fa fa-save"></i>&nbsp;Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                    <table class="table table-bordered table-hover" id="kelas">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Tahun Pemilihan</th>
                                <th>Tahun Detail</th>
                                <th>Status Jadwal</th>
                                <th>Ubah Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($jadwals as $jadwal)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $jadwal->tahun }}</td>
                                    <td>{{ $jadwal->jadwal_detail }}</td>
                                    <td>
                                        @if ($jadwal->status_jadwal == "1")
                                            <label for="" class="label label-primary"><i class="fa fa-check-circle"></i>&nbsp;Aktif</label>
                                            @else
                                            <label for="" class="label label-danger"><i class="fa fa-thumbs-up"></i>&nbsp;Tidak Aktif</label>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('operator.jadwal.aktifkan_status', [$jadwal->id]) }}" method="POST">
                                            {{ csrf_field() }} {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-up"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <a onclick="hapusJadwal({{ $jadwal->id }})" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="modalhapus">
                        <div class="modal-dialog modal-danger">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"><i class="fa fa-info-circle"></i>&nbsp;Perhatian</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Apakah anda yakin ingin menghapus data?</h4>
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="{{ route('operator.jadwal.delete') }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="id" id="id_delete">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Kembali</button>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Hapus Data</button>
                                    </form>
                                </div>
                            </div>
                        </div>
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

        function hapusJadwal(id) {
            $('#modalhapus').modal('show');
            $('#id_delete').val(id);
        }

        $(document).ready(function(){
            $("#password1, #password2").keyup(function(){
                var password = $("#password1").val();
                var ulangi = $("#password2").val();
                if($("#password1").val() == $("#password2").val()){
                    $('#password_benar').show();
                    $('#password_salah').hide();
                    $('#btn_submit').attr("disabled",false);
                }
                else{
                    $('#password_benar').hide();
                    $('#password_salah').show();
                    $('#btn_submit').attr("disabled",true);
                }
            });
        });

        function ubahOperator(id){
            $.ajax({
                url: "{{ url('operator/manajemen_anggota') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#modalubah').modal('show');
                    $('#id_edit').val(id);
                    $('#nm_anggota').val(data.nm_anggota);
                    $('#nik').val(data.nik);
                    $('#alamat').val(data.alamat);
                    $('#tahun_keanggotaan').val(data.tahun_keanggotaan);
                    $('#email').val(data.email);
                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }

        function ubahPassword(id) {
            $('#ubahpassword').modal('show');
            $('#id_password').val(id);
        }

        @if($errors->any())
            $('#modaltambah').modal('show');
        @endif
    </script>
@endpush