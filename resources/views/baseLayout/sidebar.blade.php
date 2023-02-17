<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin/dashboard') }}" class="brand-link">
        <img src="{{ asset('assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}"
                        class="nav-link @if (request()->is('admin/dashboard*')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>
                <!-- data master -->
                @if (auth()->user()->attr_is_admin)
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Master Data
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/master-data/region') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Region</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/master-data/kantor') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kantor</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/master-data/tambang') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tambang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/master-data/kendaraan') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kendaraan</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('admin/master-data/pegawai') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pegawai</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <!-- data pemesan -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Riwayat Kendaraan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/pemesanan') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pemesanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/jadwal-service') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal Service</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/konsumsi-bbm') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengisian BBM</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- logout -->
                <li class="nav-item">
                    <a href="{{ url('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-door-open"></i>
                        <p>
                            Logout
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>

                {{--                <li class="nav-item"> --}}
                {{--                    <a href="{{url('admin/article')}}" class="nav-link @if (request()->is('admin/article*')) active @endif"> --}}
                {{--                        <i class="nav-icon fas fa-newspaper"></i> --}}
                {{--                        <p> --}}
                {{--                            Article --}}
                {{--                            --}}{{-- <span class="right badge badge-danger">New</span> --}}
                {{--                        </p> --}}
                {{--                    </a> --}}
                {{--                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
