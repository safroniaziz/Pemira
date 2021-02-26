@extends('layouts.backend')
@section('location','Dashboard')

@section('location2')
    <i class="fa fa-dashboard"></i>&nbsp;KANDIDAT
@endsection
@section('user-login','Operator')
@section('sidebar-menu')
    @include('backend/operator/sidebar')
@endsection
@push('styles')
    <style>
        #chartdiv {
            width: 100%;
            height: 450px;
        }
        #chartdiv2 {
            width: 100%;
            height: 450px;
        }
        .amcharts-amexport-top .amcharts-amexport-item > .amcharts-amexport-menu {
            top: -3px!important;
            left: 2px
        }
    </style>
@endpush
@section('content')
    <div class="callout callout-info ">
        <h4>Perhatian!</h4>
        <p>
            Berikut adalah data anggota yang sudah tersedia, silahkan tambahkan jika ada anggota baru
            <br>
        </p>
    </div>
    <form action="{{ route('operator.laporan.cari_prodi') }}" method="POST">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i>&nbsp;Cari Program Studi Terlebih Dahulu</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <div class="col-md-12">
                            @if (!empty($success))
                                <div class="alert alert-success"><strong>Berhasil :</strong> {{$success }}</div>
                                
                            @endif
                            @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-success-circle"></i><strong>Berhasil :</strong> {{ $message }}
                                    </div>
                                @endif
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="fa fa-close"></i>&nbsp;<strong>Gagal :</strong> {{ $message }}
                                    </div>
                                @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Pilih Program Studi</label>
                            <select name="prodi" id="prodi" class="form-control">
                                <option disabled selected>-- pilih program studi --</option>
                                <option value="G1A0">Informatika</option>
                                <option value="G1B0">Teknik Sipil</option>
                                <option value="G1C0">Teknik Mesin</option>
                                <option value="G1D0">Teknik Elektro</option>
                                <option value="G1E0">Arsitektur</option>
                                <option value="G1F0">Sistem Informasi</option>
                            </select>
                            @if ($errors->has('prodi'))
                                <small class="form-text text-danger">{{ $errors->first('prodi') }}</small>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Pilih Angkatan</label>
                            <select name="angkatan" id="angkatan" class="form-control">
                                <option value="semua">Semua Angkatan</option>
                                @foreach ($angkatans as $angkatan)
                                    <option value="{{ $angkatan->angkatan_pemilih }}">{{ $angkatan->angkatan_pemilih }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('angkatan'))
                                <small class="form-text text-danger">{{ $errors->first('angkatan') }}</small>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp; Lakukan Pencarian</button>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </form>
    @if (isset($_POST['prodi']))
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart"></i>&nbsp;Grafik Batang Laporan Keseluruhan</h3>
                </div>
                <div class="box-body table-responsive">
                    @section('chart_data')
                        chart.data = [
                            @foreach ($grafiks as $data)
                                {
                                    "country": "No Urut {{ $data['no_urut'] }}",
                                    "visits": {{ $data['jumlah'] }}
                                },
                            @endforeach
                        ];
                    @endsection
                    <div id="chartdiv"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-pie-chart"></i>&nbsp;Grafik Lingkaran Laporan Keseluruhan</h3>
                </div>
                <div class="box-body table-responsive">
                    @section('chart_data2')
                        chart.data = [
                            @foreach ($grafiks as $data)
                                {
                                    "country": "No Urut {{ $data['no_urut'] }}",
                                    "litres": {{ $data['jumlah'] }}
                                },
                                
                            @endforeach
                        ];
                    @endsection
                <div id="chartdiv2"></div>
             </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Table Laporan Keseluruhan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover" id="kelas">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Npm Pemilih</th>
                                <th>Program Studi Pemilih</th>
                                <th>Angkatan Pemilih</th>
                                <th>No Urut Pilihan</th>
                                <th>Nama Calon Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($laporans as $laporan)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $laporan->npm_pemilih }}</td>
                                    <td>{{ $laporan->prodi_pemilih }}</td>
                                    <td>{{ $laporan->angkatan_pemilih }}</td>
                                    <td>No Urut {{ $laporan->no_urut }}</td>
                                    <td>{{ $laporan->nm_ketua }} & {{ $laporan->nm_wakil }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
    </div>
    @endif
@endsection


@if (isset($_POST['prodi']))
@push('scripts')
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script>
$(document).ready( function () {
            $('#kelas').DataTable();
        } );
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();

// Add data
@yield('chart_data')

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
series.columns.template.strokeWidth = 0;

series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;

// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.menu.align = "left";
chart.exporting.menu.verticalAlign = "top";
}); // end am4core.ready()
</script>


<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv2", am4charts.PieChart);

// Add data
@yield('chart_data2')

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "country";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

chart.hiddenState.properties.radius = am4core.percent(0);
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.menu.align = "left";
chart.exporting.menu.verticalAlign = "top";
}); // end am4core.ready()
</script>


@endpush
@endif