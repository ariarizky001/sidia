<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'siDia') }} - {{ $title ?? 'Dashboard' }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Overlayscrollbars -->
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .main-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content-header {
            position: sticky;
            top: 61px;
            z-index: 999;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        /* Collapsible Master Data Menu Styling */
        .nav-treeview {
            transition: all 0.3s ease;
        }

        body:not(.sidebar-collapse) .nav-treeview .nav-link,
        .main-sidebar:hover .nav-treeview .nav-link {
            padding-left: 3rem !important;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }
        
        body.sidebar-collapse .main-sidebar:not(:hover) .nav-treeview .nav-link {
            padding-left: 1rem !important;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .nav-treeview .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #00bcd4;
        }

        .nav-treeview .nav-link.active {
            background-color: rgba(0, 188, 212, 0.2);
            border-left-color: #00bcd4;
            color: #00bcd4;
        }

        /* Master Data Parent Menu Icon Rotation */
        #masterDataMenu ~ .nav-link i.right {
            transition: transform 0.3s ease;
        }

        /* When menu is shown */
        .nav-link[data-target="#masterDataMenu"][aria-expanded="true"] i.right {
            transform: rotate(90deg);
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <script>
        // Cek localStorage untuk status sidebar sebelumnya
        if (localStorage.getItem('sidebarState') === 'collapsed') {
            document.body.classList.add('sidebar-collapse');
        }
    </script>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">Account</span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">siDia</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name ?? 'User' }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Menu Utama Header -->
                        <li class="nav-header">MENU UTAMA</li>

                        <!-- Data Pegawai with Submenu -->
                        <li class="nav-item has-treeview {{ request()->routeIs('pegawai.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Data Pegawai
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- Semua Pegawai -->
                                <li class="nav-item">
                                    <a href="{{ route('pegawai.index') ?? '#' }}" class="nav-link {{ request()->routeIs('pegawai.index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-list"></i>
                                        <p>Semua Pegawai</p>
                                    </a>
                                </li>

                                <!-- Pegawai PNS -->
                                <li class="nav-item">
                                    <a href="{{ route('pegawai.pns') ?? '#' }}" class="nav-link {{ request()->routeIs('pegawai.pns') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-id-card"></i>
                                        <p>Pegawai PNS</p>
                                    </a>
                                </li>

                                <!-- Pegawai PPPK -->
                                <li class="nav-item">
                                    <a href="{{ route('pegawai.pppk') ?? '#' }}" class="nav-link {{ request()->routeIs('pegawai.pppk') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user-tie"></i>
                                        <p>Pegawai PPPK</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Data Sekolah -->
                        <li class="nav-item">
                            <a href="{{ route('data-sekolah.index') ?? '#' }}" class="nav-link {{ request()->routeIs('data-sekolah.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Data Sekolah</p>
                            </a>
                        </li>

                        <!-- Mapping Menu with Submenu -->
                        <li class="nav-item has-treeview {{ request()->routeIs('rombel.*', 'kebutuhan-guru.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('rombel.*', 'kebutuhan-guru.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-project-diagram"></i>
                                <p>
                                    Mapping
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- Rombel -->
                                <li class="nav-item">
                                    <a href="{{ route('rombel.index') ?? '#' }}" class="nav-link {{ request()->routeIs('rombel.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-users-cog"></i>
                                        <p>Rombel</p>
                                    </a>
                                </li>
                                <!-- Kebutuhan Guru -->
                                <li class="nav-item">
                                    <a href="{{ route('kebutuhan-guru.index') ?? '#' }}" class="nav-link {{ request()->routeIs('kebutuhan-guru.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-person-chalkboard"></i>
                                        <p>Kebutuhan Guru</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Master Data Header -->


                        <!-- Master Data Menu -->
                        <li class="nav-item has-treeview {{ request()->routeIs('status-asn.*', 'golongan.*', 'eselon.*', 'jabatan.*', 'formasi-jabatan.*', 'jenjang-pendidikan.*', 'unit-kerja.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('status-asn.*', 'golongan.*', 'eselon.*', 'jabatan.*', 'formasi-jabatan.*', 'jenjang-pendidikan.*', 'unit-kerja.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Master Data
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- Status ASN -->
                                <li class="nav-item">
                                    <a href="{{ route('status-asn.index') ?? '#' }}" class="nav-link {{ request()->routeIs('status-asn.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-id-badge"></i>
                                        <p>Status ASN</p>
                                    </a>
                                </li>

                                <!-- Golongan -->
                                <li class="nav-item">
                                    <a href="{{ route('golongan.index') ?? '#' }}" class="nav-link {{ request()->routeIs('golongan.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-layer-group"></i>
                                        <p>Golongan</p>
                                    </a>
                                </li>

                                <!-- Eselon -->
                                <li class="nav-item">
                                    <a href="{{ route('eselon.index') ?? '#' }}" class="nav-link {{ request()->routeIs('eselon.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>Eselon</p>
                                    </a>
                                </li>

                                <!-- Jabatan -->
                                <li class="nav-item">
                                    <a href="{{ route('jabatan.index') ?? '#' }}" class="nav-link {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-briefcase"></i>
                                        <p>Jabatan</p>
                                    </a>
                                </li>

                                <!-- Formasi Jabatan -->
                                <li class="nav-item">
                                    <a href="{{ route('formasi-jabatan.index') ?? '#' }}" class="nav-link {{ request()->routeIs('formasi-jabatan.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>Formasi Jabatan</p>
                                    </a>
                                </li>

                                <!-- Jenjang Pendidikan -->
                                <li class="nav-item">
                                    <a href="{{ route('jenjang-pendidikan.index') ?? '#' }}" class="nav-link {{ request()->routeIs('jenjang-pendidikan.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-graduation-cap"></i>
                                        <p>Jenjang Pendidikan</p>
                                    </a>
                                </li>

                                <!-- Unit Kerja -->
                                <li class="nav-item">
                                    <a href="{{ route('unit-kerja.index') ?? '#' }}" class="nav-link {{ request()->routeIs('unit-kerja.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-building"></i>
                                        <p>Unit Kerja</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Pengaturan Header -->
                        <li class="nav-header">PENGATURAN</li>

                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="#">siDia</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Overlayscrollbars Plugin -->
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Event listener bawaan AdminLTE saat sidebar ditutup/dibuka
            $(document).on('collapsed.lte.pushmenu', function() {
                localStorage.setItem('sidebarState', 'collapsed');
            });
            $(document).on('shown.lte.pushmenu', function() {
                localStorage.setItem('sidebarState', 'expanded');
            });

            // Fallback: simpan state saat tombol pushmenu diklik
            $('[data-widget="pushmenu"]').on('click', function() {
                setTimeout(function() {
                    if ($('body').hasClass('sidebar-collapse')) {
                        localStorage.setItem('sidebarState', 'collapsed');
                    } else {
                        localStorage.setItem('sidebarState', 'expanded');
                    }
                }, 100);
            });
        });
    </script>

</body>
</html>
