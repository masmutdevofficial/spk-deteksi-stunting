<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link d-flex justify-content-center align-items-center">
        <span class="brand-text font-weight-light font-weight-bold">ADMIN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('data-kriteria') }}" class="nav-link {{ request()->is('data-kriteria') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Data Kriteria</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('data-siswa') }}" class="nav-link {{ request()->is('data-siswa') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Data Siswa</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('data-user') }}" class="nav-link {{ request()->is('data-user') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Data User</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('penilaian') }}" class="nav-link {{ request()->is('penilaian') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Penilaian</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('hasil-penilaian') }}" class="nav-link {{ request()->is('hasil-penilaian') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Hasil Penilaian</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('grafik-kriteria') }}" class="nav-link {{ request()->is('grafik-kriteria') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Grafik Kriteria</p>
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
