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

<li class="treeview {{ set_active(['operator.laporan.keseluruhan','operator.laporan.prodi','operator.laporan.cari_prodi','operator.laporan.angkatan','operator.laporan.cari_angkatan','operator.laporan.jenjang','operator.laporan.cari_jenjang']) }}">
    <a href="#">
        <i class="fa fa-university"></i> <span>Hasil Rekapitulasi</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu ">
        <li class="{{ set_active(['operator.laporan.keseluruhan']) }}"><a href="{{ route('operator.laporan.keseluruhan') }}"><i class="fa fa-calculator"></i>Rekap Keseluruhan</a></li>
        <li class="{{ set_active(['operator.laporan.prodi','operator.laporan.cari_prodi']) }}"><a href="{{ route('operator.laporan.prodi') }}"><i class="fa fa-calculator"></i>Rekap Per Program Studi</a></li>
        <li class="{{ set_active(['operator.laporan.angkatan','operator.laporan.cari_angkatan']) }}"><a href="{{ route('operator.laporan.angkatan') }}"><i class="fa fa-calculator"></i>Rekap Per Angkatan</a></li>
        <li class="{{ set_active(['operator.laporan.jenjang','operator.laporan.cari_jenjang']) }}"><a href="{{ route('operator.laporan.jenjang') }}"><i class="fa fa-calculator"></i>Rekap Per Jenjang</a></li>
    </ul>
</li>

<li class="">
    <a style="color: red;" data-toggle="control-sidebar" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off"></i>&nbsp; {{ __('Logout') }}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>