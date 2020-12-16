<li class="header" style="font-weight:bold;">MENU UTAMA</li>
<li class="{{ set_active('operator.dashboard') }}">
    <a href="{{ route('operator.dashboard') }}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
</li>

<li class="{{ set_active('operator.jadwal') }}">
    <a href="{{ route('operator.jadwal') }}">
        <i class="fa fa-clock-o"></i> <span>Jadwal Pemira</span>
    </a>
</li>

<li class="{{ set_active('operator.kandidat') }}">
    <a href="{{ route('operator.kandidat') }}">
        <i class="fa fa-users"></i> <span>Kandidat</span>
    </a>
</li>

<li class="treeview {{ set_active(['operator.laporan.keseluruhan']) }}">
    <a href="#">
        <i class="fa fa-university"></i> <span>Hasil Rekapitulasi</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu ">
        <li class="{{ set_active(['operator.laporan.keseluruhan']) }}"><a href="{{ route('operator.laporan.keseluruhan') }}"><i class="fa fa-wpforms"></i>Rekap Keseluruhan</a></li>
        <li class="{{ set_active(['operator.laporan.prodi']) }}"><a href="{{ route('operator.laporan.prodi') }}"><i class="fa fa-wpforms"></i>Rekap Per Program Studi</a></li>
    </ul>
</li>

<li class="">
    <a href="">
        <i class="fa fa-power-off text-danger"></i> <span class="text-danger">Keluar</span>
    </a>
</li>