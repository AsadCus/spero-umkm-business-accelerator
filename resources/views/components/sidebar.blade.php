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
                class="dropdown {{ Request::is('kuesioner-unverif') || Request::is('umkm-qualified') || Request::is('umkm-unqualified') || Request::is('kuesioner-verif') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>UMKM</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('kuesioner-unverif') ? 'active' : '' }}"><a class="nav-link"
                            href="/kuesioner-unverif">UMKM Registered</a></li>
                    <li class="{{ Request::is('umkm-qualified') ? 'active' : '' }}"><a class="nav-link"
                            href="/umkm-qualified">UMKM Qualified</a></li>
                    <li class="{{ Request::is('umkm-unqualified') ? 'active' : '' }}"><a class="nav-link"
                            href="/umkm-unqualified">UMKM UnQualified</a></li>
                    <li class="{{ Request::is('kuesioner-verif') ? 'active' : '' }}"><a class="nav-link"
                            href="/kuesioner-verif">UMKM Verified</a></li>
                </ul>
            </li>
            <li class="dropdown {{ Request::is('umkm-qualified') || Request::is('umkm-assesment') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Kurasi
                        UMKM</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('umkm-qualified') ? 'active' : '' }}"><a class="nav-link"
                            href="/umkm-qualified">UMKM Qualified</a></li>
                    <li class="{{ Request::is('umkm-assesment') ? 'active' : '' }}"><a class="nav-link"
                            href="/umkm-assesment">UMKM Assesment</a></li>
                </ul>
            </li>
            <li
                class="dropdown {{ Request::is('user/admin') || Request::is('user/penyedia') || Request::is('user/kurator') || Request::is('user/umkm') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Management
                        Akun</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('user/admin') ? 'active' : '' }}"><a class="nav-link"
                            href="/user/admin">Admin</a></li>
                    <li class="{{ Request::is('user/penyedia') ? 'active' : '' }}"><a class="nav-link"
                            href="/user/penyedia"> Penyedia</a></li>
                    <li class="{{ Request::is('user/kurator') ? 'active' : '' }}"><a class="nav-link"
                            href="/user/kurator"> Kurator</a></li>
                    <li class="{{ Request::is('user/umkm') ? 'active' : '' }}"><a class="nav-link" href="/user/umkm">
                            UMKM</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
