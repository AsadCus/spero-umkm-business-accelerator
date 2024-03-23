<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('dashboard') }}">UMKM</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('dashboard') }}">UMKM</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li
                class="dropdown {{ Request::is('kuesioner') || Request::is('kuesioner-skor') || Request::is('kuesioner-kurasi') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Settings</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('kuesioner-all') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ url('kuesioner-all') }}">Kuesioner</a></li>
                    <li class="{{ Request::is('kuesioner-skor') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ url('kuesioner-skor') }}">Kuesioner Skor</a></li>
                    <li class="{{ Request::is('kuesioner-kurasi') ? 'active' : '' }}"><a class="nav-link"
                            href="/kuesioner-kurasi">Kuesioner Kurasi</a>
                    </li>
                </ul>
            </li>
            <li
                class="dropdown {{ Request::is('umkm-unverif') || Request::is('umkm-qualified') || Request::is('umkm-unqualified') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>UMKM</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('umkm-unverif') ? 'active' : '' }}"><a class="nav-link"
                            href="/umkm-unverif">UMKM Registered</a></li>
                    <li class="{{ Request::is('umkm-qualified') ? 'active' : '' }}"><a class="nav-link"
                            href="/umkm-qualified">UMKM Qualified</a></li>
                    <li class="{{ Request::is('umkm-unqualified') ? 'active' : '' }}"><a class="nav-link"
                            href="/umkm-unqualified">UMKM UnQualified</a></li>
                </ul>
            </li>
            <li
                class="dropdown {{ Request::is('kurator/umkm-qualified') || Request::is('kurator/umkm-assesment') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Kurasi
                        UMKM</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('kurator/umkm-qualified') ? 'active' : '' }}"><a class="nav-link"
                            href="/kurator/umkm-qualified">UMKM Qualified</a></li>
                    <li class="{{ Request::is('kurator/umkm-assesment') ? 'active' : '' }}"><a class="nav-link"
                            href="/kurator/umkm-assesment">UMKM Assesment</a></li>
                </ul>
            </li>
            <li
                class="dropdown {{ Request::is('akun/admin') || Request::is('akun/penyedia') || Request::is('akun/kurator') || Request::is('akun/umkm') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Management
                        Akun</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('akun/admin') ? 'active' : '' }}"><a class="nav-link"
                            href="/akun/admin">Admin</a></li>
                    <li class="{{ Request::is('akun/penyedia') ? 'active' : '' }}"><a class="nav-link"
                            href="/akun/penyedia"> Penyedia</a></li>
                    <li class="{{ Request::is('akun/kurator') ? 'active' : '' }}"><a class="nav-link"
                            href="/akun/kurator"> Kurator</a></li>
                    <li class="{{ Request::is('akun/umkm') ? 'active' : '' }}"><a class="nav-link" href="/akun/umkm">
                            UMKM</a></li>
                </ul>
            </li>
            <li
                class="dropdown {{ Request::is('provinsi') || Request::is('kabupaten') || Request::is('kecamatan') || Request::is('kelurahan') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Management
                        Wilayah</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('provinsi') ? 'active' : '' }}"><a class="nav-link"
                            href="/provinsi">Provinsi</a></li>
                    <li class="{{ Request::is('kabupaten') ? 'active' : '' }}"><a class="nav-link" href="/kabupaten">
                            Kabupaten</a></li>
                    <li class="{{ Request::is('kecamatan') ? 'active' : '' }}"><a class="nav-link" href="/kecamatan">
                            Kecamatan</a></li>
                    <li class="{{ Request::is('kelurahan') ? 'active' : '' }}"><a class="nav-link" href="/kelurahan">
                            Kelurahan</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
