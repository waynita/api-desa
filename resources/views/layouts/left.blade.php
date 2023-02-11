  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">    
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <img src="{{asset('dist/img/cat.jpeg')}}" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="{{asset('dist/img/cat.jpeg')}}" class="img-circle elevation-2" alt="User Image">

            <p>
               Hello, {{ session('username') }}
            </p>
            <p>
              Born, {{ DateFormat(session('created_at')) }}
            </p>
          </li>
          
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="{{ URL('logout') }}" class="btn btn-default btn-flat float-right">Sign out</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar  sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Selang Nangka</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="{{URL('/')}}" class="d-block"> Hello, {{ session('username') }} </a>
        </div>
      </div>
      
      <!-- Sidebar Menu -->

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> 
          <li class="nav-item dashboard">
            <a href="/" class="nav-link dashboard">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>  
        
          <li class="nav-item dashboard">
            <a href="#" class="nav-link dashboard">
              <i class="nav-icon fas fa-file"></i>
              <p>
              Kelola Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ URL('data_penduduk') }}" class="nav-link dashboard">
                  <i class="fas fa-user nav-icon"></i>
                  <p>Data Penduduk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('data_keluarga') }}" class="nav-link dashboard">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Data Keluarga</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item dashboard">
            <a href="#" class="nav-link dashboard">
              <i class="nav-icon fas fa-sync"></i>
              <p>
              Sirkulasi Penduduk
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ URL('sirkulasi_data_lahir') }}" class="nav-link dashboard">
                  <i class="fas fa-baby nav-icon"></i>
                  <p>Data Kelahiran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('sirkulasi_meninggal') }}" class="nav-link dashboard">
                  <i class="fas fa-user-alt-slash nav-icon"></i>
                  <p>Data Meninggal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('sirkulasi_pendatang') }}" class="nav-link dashboard">
                  <i class="fas fa-user-plus nav-icon"></i>
                  <p>Data Pendatang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('sirkulasi_pindah') }}" class="nav-link dashboard">
                  <i class="fas fa-people-carry nav-icon"></i>
                  <p>Data Pindah</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- <li class="nav-item dashboard">
            <a href="#" class="nav-link dashboard">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
              Kelola Surat
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ URL('') }}" class="nav-link dashboard">
                  <i class="fas fa-envelope nav-icon"></i>
                  <p>Surat Domisili</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('') }}" class="nav-link dashboard">
                  <i class="fas fa-envelope nav-icon"></i>
                  <p>Surat Kelahiran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('') }}" class="nav-link dashboard">
                  <i class="fas fa-envelope nav-icon"></i>
                  <p>Surat Kematian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('') }}" class="nav-link dashboard">
                  <i class="fas fa-envelope nav-icon"></i>
                  <p>Surat Pendatang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('') }}" class="nav-link dashboard">
                  <i class="fas fa-envelope nav-icon"></i>
                  <p>Surat Pindah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('') }}" class="nav-link dashboard">
                  <i class="fas fa-envelope nav-icon"></i>
                  <p>Surat Pengantar</p>
                </a>
              </li>
            </ul>
          </li> -->

          <li class="nav-item dashboard">
            <a href="#" class="nav-link dashboard">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
              Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ URL('laporan_penduduk') }}" class="nav-link dashboard">
                  <i class="fas fa-file nav-icon"></i>
                  <p>Data Penduduk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('laporan_keluarga') }}" class="nav-link dashboard">
                  <i class="fas fa-file-alt nav-icon"></i>
                  <p>Data Keluarga</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('laporan_lahir') }}" class="nav-link dashboard">
                  <i class="fas fa-file-medical-alt nav-icon"></i>
                  <p>Data Lahir</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('laporan_meninggal') }}" class="nav-link dashboard">
                  <i class="fas fa-file-medical nav-icon"></i>
                  <p>Data Meninggal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('laporan_pendatang') }}" class="nav-link dashboard">
                  <i class="fas fa-copy nav-icon"></i>
                  <p>Data Pendatang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('laporan_pindah') }}" class="nav-link dashboard">
                  <i class="fas fa-file-signature nav-icon"></i>
                  <p>Data Pindah</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <script>
    
  </script>