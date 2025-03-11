      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a class="logo">
              <img
                src="{{ asset('template/assets/img/kaiadmin/logo_light.svg') }}"
                alt="navbar brand"
                class="navbar-brand"
                height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              </span>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Master Data</h4>
              </li>
              <li class="nav-item {{ request()->is('data-pasien') ? 'active' : '' }}">
                <a href="{{ route('pasien') }}">
                  <i class="fas fa-user"></i>
                  <p>Data Pasien</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('dokter') ? 'active' : '' }}">
                <a href="{{ route('dokter.index') }}">
                  <i class="fas fa-user-md"></i>
                  <p>Data Nakes</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Farmasi</h4>
              </li>
              <li class="nav-item {{ request()->is('distributor') ? 'active' : '' }}">
                <a href="{{ route('distributor') }}">
                  <i class="fas fa-truck"></i>
                  <p>Data Distributor</p>
                </a>
              </li>
              <li class="nav-item {{ request()->routeIs('obat-masuk.index') ? 'active' : '' }}">
                <a href="{{ route('obat-masuk.index') }}">
                  <i class="fas fa-pills"></i>
                  <p>Data Obat Masuk</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('penjualan-obat') ? 'active' : '' }}">
                <a href="{{ route('penjualan-obat') }}">
                  <i class="fas fa-money-bill"></i>
                  <p>Penjualan Obat</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('laporan-farmasi') ? 'active' : '' }}">
                <a href="{{ route('laporan-farmasi') }}">
                  <i class="fas fa-file-alt"></i>
                  <p>Laporan Farmasi</p>
                </a>
              </li>

              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Registrasi Pasien</h4>
              </li>
              <li class="nav-item {{ request()->is('poli-umum', 'poli-gigi', 'poli-kia') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#submenu-rawat-jalan">
                  <i class="fas fa-walking"></i>
                  <p>Rawat Jalan</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse {{ request()->is('poli-umum', 'poli-gigi', 'poli-kia') ? 'show' : '' }}" id="submenu-rawat-jalan">
                  <ul class="nav nav-collapse">
                    <li class="{{ request()->is('poli-umum') ? 'active' : '' }}">
                      <a href="{{ route('poli-umum') }}">
                        <span class="sub-item">Poli Umum</span>
                      </a>
                    </li>
                    <li class="{{ request()->is('poli-gigi') ? 'active' : '' }}">
                      <a href="{{ route('poli-gigi') }}">
                        <span class="sub-item">Poli Gigi</span>
                      </a>
                    </li>
                    <li class="{{ request()->is('poli-kia') ? 'active' : '' }}">
                      <a href="{{ route('poli-kia') }}">
                        <span class="sub-item">Poli KIA</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item {{ request()->is('rawat-inap') ? 'active' : '' }}">
                <a href="{{ route('rawat-inap') }}">
                  <i class="fas fa-bed"></i>
                  <p>Rawat Inap</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('poli-gigi') ? 'active' : '' }}">
                <a href="{{ route('poli-gigi') }}">
                  <i class="fas fa-tooth"></i>
                  <p>Poli Gigi</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->