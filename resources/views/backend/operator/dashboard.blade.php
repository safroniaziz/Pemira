@extends('layouts.backend')
@section('location','Dashboard')
@section('location2')
    <i class="fa fa-dashboard"></i>&nbsp;DASHBOARD
@endsection
@section('user-login','Operator')
@section('sidebar-menu')
    @include('backend/operator/sidebar')
@endsection
@push('styles')
    <style>
        #chartdiv {
            width: 90%;
            height: 450px;
        }
        #chartdiv2 {
            width: 70%;
            height: 380px;
        }
    </style>
@endpush
@section('content')
    <div class="callout callout-info ">
        <h4>SELAMAT DATANG!</h4>
        <p>
            Sistem Informasi Pemilihan Raya (Pemira) adalah aplikasi yang digunakan untuk melakukan pemilihan calon gubernur/wakil gubernur atau presiden/wakil presiden Badan Eksekutif Mahasiwa (BEM) Universitas Bengkulu

            <br>
            <b><i>Catatan:</i></b> Untuk keamanan, jangan lupa keluar setelah menggunakan aplikasi
        </p>
    </div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $kandidat }}</h3>

                    <p>Jumlah Kandidat</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>@if (!empty($jadwal_detail))
                        {{ $jadwal_detail->jadwal_detail }}
                    @endif</h3>

                    <p>Tanggal Pemira</p>
                </div>
                <div class="icon">
                    <i class="fa fa-barcode"></i>
                </div>
                <a href="" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                    <div class="inner">
                    <h3>@if (!empty($waktu))
                        {{ $waktu->waktu_awal }}
                    @endif</h3>

                    <p>Waktu Mulai</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                    <div class="inner">
                    <h3>@if (!empty($waktu))
                        {{ $waktu->waktu_akhir }}
                    @endif</h3>

                    <p>Waktu Selesai</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    
@endsection
