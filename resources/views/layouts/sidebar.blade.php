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
                <a href="{{ url('data-bayi') }}" class="nav-link {{ request()->is('data-bayi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-baby"></i>
                    <p>Data Bayi</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('status-gizi') }}" class="nav-link {{ request()->is('status-gizi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-weight"></i>
                    <p>Status Gizi</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('jadwal-kegiatan') }}" class="nav-link {{ request()->is('jadwal-kegiatan') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Jadwal Kegiatan</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('jadwal-penimbangan') }}" class="nav-link {{ request()->is('jadwal-penimbangan') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-hand-holding-medical"></i>
                    <p>Jadwal Penimbangan</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('konsultasi') }}" class="nav-link {{ request()->is('konsultasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>Konsultasi</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('hasil-deteksi') }}" class="nav-link {{ request()->is('hasil-deteksi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-notes-medical"></i>
                    <p>Hasil Penilaian</p>
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
