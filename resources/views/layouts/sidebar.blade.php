<header class="header">
    <a href="index.html" class="logo">AHP</a>
    <button type="button" class="button-close fa fa-times js__menu_close"></button>
</header>
<!-- /.header -->
<div class="content">
    <div class="navigation">
        <ul class="menu js__accordion">
            <li class="{{ request()->is('dashboard') ? 'current active' : '' }}">
                <a class="waves-effect" href="{{ route('dashboard.index') }}"><i
                        class="menu-icon mdi mdi-view-dashboard"></i><span>Dashboard</span></a>
            </li>
           
            @if(Auth::user()->jabatan == 'admin')
            <li class="{{ request()->is('kriteria*') ? 'current active' : '' }}">
                <a class="waves-effect parent-item js__control" href="#"><i
                        class="menu-icon mdi mdi-view-list"></i><span>Master</span><span
                        class="menu-arrow fa fa-angle-down"></span></a>
                <ul class="sub-menu js__content">
                    <li class="{{ request()->is('kriteria') ? 'current' : '' }}"><a
                            href="{{ route('kriteria.index') }}">Kriteria</a></li>
                    <li class="{{ request()->is('kriteria-sub*') ? 'current' : '' }}"><a
                            href="{{ route('sub.kriteria.index') }}">Sub Kriteria</a></li>
                </ul>
                <!-- /.sub-menu js__content -->
            </li>
            <li class="{{ request()->is('hitung/kriteria') ? 'current' : '' }}">
                <a class="waves-effect" href="{{ route('hitung.index') }}"><i
                        class="menu-icon mdi mdi-format-list-bulleted"></i><span>Bobot Kriteria</span></a>
            </li>
            
            <li class="{{ request()->is('hitung/sub-kriteria*') ? 'current active' : '' }}">
                <a class="waves-effect parent-item js__control" href="#"><i
                        class="menu-icon mdi mdi-creation"></i><span>Bobot Sub Kriteria</span><span
                        class="menu-arrow fa fa-angle-down"></span></a>
                <ul class="sub-menu js__content">
                    @foreach (DB::table('kriteria')->get() as $krit)
                        <li class="{{ request()->is('hitung/sub-kriteria/' . $krit->id) ? 'current' : '' }}">
                            <a href="{{ route('sub-hitung.index', $krit->id) }}">{{ $krit->nama }}</a>
                        </li>
                    @endforeach
                </ul>
                <!-- /.sub-menu js__content -->
            </li>
            @endif
            <li class="{{ request()->is('hitung/alternatif') ? 'current active' : '' }}">
                <a class="waves-effect" href="{{ route('alternatif.index') }}"><i
                        class="menu-icon mdi mdi-creation"></i><span>Bobot Alternatif</span></a>
            </li>
            @if(Auth::user()->jabatan == 'admin')
            <li class="{{ request()->is('user*') ? 'current active' : '' }}">
                <a class="waves-effect" href="{{ route('user.index') }}"><i
                        class="menu-icon mdi mdi-account-circle"></i><span>User</span></a>
            </li>
            @endif

        </ul>
        <!-- /.menu js__accordion -->
    </div>
    <!-- /.navigation -->
</div>
<!-- /.content -->
