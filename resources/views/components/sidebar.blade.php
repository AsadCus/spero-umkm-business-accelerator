<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('dashboard') }}"><img src="{{ asset('img/logo2.png') }}" width="25"> UMKM Levelup</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('dashboard') }}">UL</a>
        </div>
        <ul class="sidebar-menu">
            @if (Session::get('id_role') == 2)
                <li class="menu-header">Dashboard</li>
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link {{ '' }}" href="{{ url('dashboard') }}"><i
                            class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
            @else
            @endif
            @if (Session::get('id_role') == 4 or Session::get('id_role') == 3 or Session::get('id_role') == 2)
                <li class="menu-header">Kuesioner</li>
                <li class="{{ Request::is('kuesioner-all') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('kuesioner-all') }}"><i class="fas fa-list"></i> <span>List
                            Kuesioner</span></a>
                </li>
                <li class="{{ Request::is('kuesioner-unverif') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('kuesioner-unverif') }}"><i class="fas fa-user-xmark"></i>
                        <span>List - Unverified</span></a>
                </li>
                <li class="{{ Request::is('kuesioner-verif') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('kuesioner-verif') }}"><i class="fas fa-user-check"></i>
                        <span>List - Verified</span></a>
                </li>
                <li class="{{ Request::is('management-sertifikat') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('management-sertifikat') }}"><i class="fas fa-file"></i>
                        <span>Management Sertifikat</span></a>
                </li>
                <li class="{{ Request::is('score') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('score') }}"><i class="fas fa-sliders"></i>
                        <span>Score</span></a>
                </li>
            @endif

            @if (Session::get('id_role') == 5)
                <li class="menu-header">Learning Sistem</li>
                <li class="{{ Request::is('list-materi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('list-materi') }}"><i class="fas fa-graduation-cap"></i>
                        <span>List Kategori Materi</span></a>
                </li>
            @endif

            @if (Session::get('id_role') == 2)
                <li class="menu-header">Learning Sistem</li>
                {{-- <li class="{{ Request::is('list-kategori-materi') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{url('list-kategori-materi')}}"><i class="fas fa-tags"></i> <span>List Kategori Materi</span></a>
                </li> --}}
                <li class="{{ Request::is('list-materi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('list-materi') }}"><i class="fas fa-graduation-cap"></i>
                        <span>List Kategori Materi</span></a>
                </li>

                <li class="{{ Request::is('user-progres') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('user-progres') }}"><i class="fas fa-users"></i> <span>List
                            Progress Learning</span></a>
                </li>

                <li class="{{ Request::is('list-pengumuman') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('list-pengumuman') }}"><i class="fas fa-bullhorn"></i>
                        <span>Pengumuman</span></a>
                </li>
                <li class="{{ Request::is('materi-chatting') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('materi-chatting') }}"><i class="fas fa-comments"></i>
                        <span>Materi Chatting</span></a>
                </li>


                <li class="menu-header">Management Wilayah</li>
                <li class="{{ Request::is('provinsi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('provinsi') }}"><i class="fas fa-database"></i> <span>List
                            Provinsi</span></a>
                </li>
                <li class="{{ Request::is('kabupaten') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('kabupaten') }}"><i class="fas fa-database"></i> <span>List
                            Kabupaten & Kota</span></a>
                </li>
                <li class="{{ Request::is('kecamatan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('kecamatan') }}"><i class="fas fa-database"></i> <span>List
                            Kecamatan</span></a>
                </li>
                <li class="{{ Request::is('kelurahan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('kelurahan') }}"><i class="fas fa-database"></i> <span>List
                            Kelurahan</span></a>
                </li>

                <li class="menu-header">Portal Lama</li>
                <li class="{{ Request::is('old-portal') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('old-portal') }}"><i class="fas fa-database"></i> <span>List
                            User</span></a>
                </li>


                <li class="menu-header">Konfig & Lain</li>
                <li class="{{ Request::is('set-level') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('set-level') }}"><i class="fas fa-wrench"></i> <span>Setting
                            Level</span></a>
                </li>

                <li class="{{ Request::is('set-score') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('set-score') }}"><i class="fas fa-sliders"></i>
                        <span>Setting Score</span></a>
                </li>

                <li class="{{ Request::is('import-data') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('import-data') }}"><i class="fas fa-upload"></i> <span>Import
                            Data</span></a>
                </li>

                {{-- <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="#"><i class="fas fa-user"></i> <span>User</span></a>
                </li>

                <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="#"><i class="fas fa-cogs"></i> <span>Hak Akses</span></a>
                </li> --}}

                {{-- <li class="menu-header">Konfig & Lain</li>
                <li class="{{ Request::is('set-level') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{url('set-level')}}"><i class="fas fa-wrench"></i> <span>Setting Level</span></a>
                </li> --}}
            @else
            @endif
        </ul>
    </aside>
</div>
