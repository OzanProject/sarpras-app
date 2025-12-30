<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ url('/') }}" class="navbar-brand mx-4 mb-3">
            @if(isset($global_settings['logo']) && $global_settings['logo'])
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                    <img src="{{ asset('storage/' . $global_settings['logo']) }}" class="rounded-circle" style="width: 35px; height: 35px;" alt="Logo">
                    <h5 class="text-primary mb-0 ms-2 text-truncate d-none d-lg-inline-block" style="max-width: 150px;">{{ $global_settings['nama_sekolah'] ?? 'SARPRAS' }}</h5>
                </div>
            @else
                <h3 class="text-primary"><i class="fa fa-school me-2"></i>SARPRAS</h3>
            @endif
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('darkpan/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <span>{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            
            @if(Auth::user()->role == 'admin')
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('kategori.*') || request()->routeIs('barang.*') ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-boxes me-2"></i>Data Master</a>
                    <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('kategori.*') || request()->routeIs('barang.*') || request()->routeIs('room.*') ? 'show' : '' }}">
                        <a href="{{ route('kategori.index') }}" class="dropdown-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">Kategori</a>
                        <a href="{{ route('room.index') }}" class="dropdown-item {{ request()->routeIs('room.*') ? 'active' : '' }}">Ruangan</a>
                        <a href="{{ route('barang.index') }}" class="dropdown-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">Data Barang</a>
                    </div>
                </div>
                
                <a href="{{ route('peminjaman.index') }}" class="nav-item nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}"><i class="fa fa-handshake me-2"></i>Peminjaman</a>
                <a href="{{ route('scan.index') }}" class="nav-item nav-link {{ request()->routeIs('scan.*') ? 'active' : '' }}"><i class="fa fa-qrcode me-2"></i>Scan QR</a>
                <a href="{{ route('maintenance.index') }}" class="nav-item nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}"><i class="fa fa-tools me-2"></i>Perbaikan</a>
                <a href="{{ route('report.index') }}" class="nav-item nav-link {{ request()->routeIs('report.*') ? 'active' : '' }}"><i class="fa fa-file-alt me-2"></i>Laporan</a>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('setting.*') || request()->routeIs('user.*') ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-cogs me-2"></i>Pengaturan</a>
                    <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('setting.*') || request()->routeIs('user.*') ? 'show' : '' }}">
                        <a href="{{ route('setting.index') }}" class="dropdown-item {{ request()->routeIs('setting.index') ? 'active' : '' }}">Umum</a>
                        <a href="{{ route('user.index') }}" class="dropdown-item {{ request()->routeIs('user.*') ? 'active' : '' }}">Data Pengguna</a>
                    </div>
                </div>
            @else
                <!-- User Menu -->
                <a href="{{ route('user.peminjaman.index') }}" class="nav-item nav-link {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}"><i class="fa fa-history me-2"></i>Riwayat Peminjaman</a>
            @endif
        </div>
    </nav>
</div>
