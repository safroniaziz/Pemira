@extends('layouts.users')
@section('user-login')
    @if(Session::get('login') && Session::get('login',1))
        {{ Session::get('nama') }}
    @endif
@endsection
@section('user-login2')
    @if(Session::get('login') && Session::get('login',1))
        {{ Session::get('nama') }}
    @endif
@endsection
@section('logout')
    <a href="{{ route('panda.logout') }}" class="btn btn-default btn-flat btn-danger" style="color: white">Logout</a>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (count($sudah)>0)
                <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <i class="fa fa-success-circle"></i><strong>Selamat :</strong> Pilihanmu berhasil disimpan, kamu tidak bisa mengubah pilihan yang sudah tersimpan !!
                </div>
                @else
            @endif
        </div>
        @foreach ($kandidats as $kandidat)

            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <label for="">Kandidat Nomor Urut  {{ $kandidat->no_urut }}</label>
                        

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item text-center" style="cursor: pointer">
                                <img class="profile-user-img img-responsive" style="width: 100%" src="{{ asset('storage/'.$kandidat->banner) }}" alt="User profile picture">
                        <h3 class="profile-username text-center">{{ $kandidat->nm_ketua }} <br> & <br> {{ $kandidat->nm_wakil }}</h3>

                            </li>
                        </ul>
                        @if (count($sudah)>0)
                            <button disabled class="btn btn-primary btn-block"><i class="fa fa-check-circle"></i>&nbsp; Pilih</button>
                            @else
                            <form action="{{ route('pemilih.pilih',[$kandidat->id,$kandidat->slug]) }}" method="POST">
                                {{ csrf_field() }} {{ method_field('POST') }}
                                <button type="submit" name="submit" class="btn btn-primary btn-block"><i class="fa fa-check-circle"></i>&nbsp; Pilih</button>
                            </form>
                        @endif
                    </div>
                <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>    
        @endforeach
    </div>
@endsection