<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">

        {{-- ===== Brand / Logo ===== --}}
        <a href="{{ url('/') }}" class="navbar-brand mx-3 mb-3 mt-2">
            <div class="d-flex align-items-center gap-3">
                @if(isset($global_settings['logo']) && $global_settings['logo'])
                    <img src="{{ asset('storage/' . $global_settings['logo']) }}"
                         style="width:38px; height:38px; border-radius:10px; object-fit:cover; border:2px solid rgba(14,165,233,.5);"
                         alt="Logo">
                @else
                    <div style="width:38px; height:38px; background:linear-gradient(135deg,#0ea5e9,#06b6d4); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; color:#fff; flex-shrink:0;">
                        <i class="fa fa-school"></i>
                    </div>
                @endif
                <div>
                    <div style="font-weight:800; font-size:.95rem; color:#fff; line-height:1.1;">
                        {{ $global_settings['nama_sekolah'] ?? 'SARPRAS' }}
                    </div>
                    <div style="font-size:.7rem; color:#7dd3fc; font-weight:500;">
                        Sarana Prasarana
                    </div>
                </div>
            </div>
        </a>

        {{-- ===== User Info ===== --}}
        <div class="d-flex align-items-center ms-3 mb-4 p-3"
             style="background:rgba(255,255,255,.06); border-radius:14px; border:1px solid rgba(255,255,255,.1);">
            <div class="position-relative">
                <img class="rounded-circle"
                     src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('darkpan/img/user.jpg') }}"
                     style="width:42px; height:42px; border:2px solid rgba(14,165,233,.6); object-fit:cover;"
                     alt="">
                <div style="position:absolute; bottom:0; right:0; width:11px; height:11px; background:#10b981; border-radius:50%; border:2px solid #1e3a5f;"></div>
            </div>
            <div class="ms-3">
                <div style="font-weight:700; font-size:.875rem; color:#fff;">{{ Auth::user()->name }}</div>
                <div style="font-size:.72rem; color:#7dd3fc; font-weight:500;">
                    <i class="fa fa-circle" style="font-size:.4rem; vertical-align:middle;"></i>
                    {{ ucfirst(Auth::user()->role->name ?? 'User') }}
                </div>
            </div>
        </div>

        {{-- ===== Nav Section Label ===== --}}
        <div style="font-size:.65rem; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:1px; padding:0 20px 8px;">
            Menu Utama
        </div>

        <div class="navbar-nav w-100">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            @if(Auth::user()->role->name == 'admin' || Auth::user()->role->permissions->count() > 0)

                @if(Gate::check('kategori.view') || Gate::check('barang.view') || Gate::check('room.view'))
                    <div class="nav-item dropdown">
                        <a href="#"
                           class="nav-link dropdown-toggle {{ request()->routeIs('kategori.*') || request()->routeIs('barang.*') || request()->routeIs('room.*') ? 'active' : '' }}"
                           data-bs-toggle="dropdown">
                            <i class="fa fa-boxes me-2"></i>Data Master
                        </a>
                        <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('kategori.*') || request()->routeIs('barang.*') || request()->routeIs('room.*') ? 'show' : '' }}">
                            @can('kategori.view')
                                <a href="{{ route('kategori.index') }}"
                                   class="dropdown-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                                   <i class="fa fa-tag me-2" style="font-size:.75rem;"></i>Kategori
                                </a>
                            @endcan
                            @can('room.view')
                                <a href="{{ route('room.index') }}"
                                   class="dropdown-item {{ request()->routeIs('room.*') ? 'active' : '' }}">
                                   <i class="fa fa-door-open me-2" style="font-size:.75rem;"></i>Ruangan
                                </a>
                            @endcan
                            @can('barang.view')
                                <a href="{{ route('barang.index') }}"
                                   class="dropdown-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                                   <i class="fa fa-box me-2" style="font-size:.75rem;"></i>Data Barang
                                </a>
                            @endcan
                        </div>
                    </div>
                @endif

                @can('peminjaman.view')
                    <a href="{{ route('peminjaman.index') }}"
                       class="nav-item nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                        <i class="fa fa-handshake me-2"></i>Peminjaman
                    </a>
                @endcan

                @can('scan.view')
                    <a href="{{ route('scan.index') }}"
                       class="nav-item nav-link {{ request()->routeIs('scan.*') ? 'active' : '' }}">
                        <i class="fa fa-qrcode me-2"></i>Scan QR
                    </a>
                @endcan

                @can('maintenance.view')
                    <a href="{{ route('maintenance.index') }}"
                       class="nav-item nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
                        <i class="fa fa-tools me-2"></i>Perbaikan
                    </a>
                @endcan

                @can('report.view')
                    <a href="{{ route('report.index') }}"
                       class="nav-item nav-link {{ request()->routeIs('report.*') ? 'active' : '' }}">
                        <i class="fa fa-file-alt me-2"></i>Laporan
                    </a>
                @endcan

                @if(Gate::check('setting.view') || Gate::check('user.view') || Gate::check('role.view'))
                    {{-- Section label --}}
                    <div style="font-size:.65rem; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:1px; padding:12px 20px 8px; margin-top:4px;">
                        Pengaturan
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#"
                           class="nav-link dropdown-toggle {{ request()->routeIs('setting.*') || request()->routeIs('user.*') || request()->routeIs('role.*') ? 'active' : '' }}"
                           data-bs-toggle="dropdown">
                            <i class="fa fa-cogs me-2"></i>Pengaturan
                        </a>
                        <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('setting.*') || request()->routeIs('user.*') || request()->routeIs('role.*') ? 'show' : '' }}">
                            @can('setting.view')
                                <a href="{{ route('setting.index') }}"
                                   class="dropdown-item {{ request()->routeIs('setting.index') ? 'active' : '' }}">
                                   <i class="fa fa-sliders-h me-2" style="font-size:.75rem;"></i>Umum
                                </a>
                            @endcan
                            @can('role.view')
                                <a href="{{ route('role.index') }}"
                                   class="dropdown-item {{ request()->routeIs('role.*') ? 'active' : '' }}">
                                   <i class="fa fa-shield-alt me-2" style="font-size:.75rem;"></i>Hak Akses
                                </a>
                            @endcan
                            @can('user.view')
                                <a href="{{ route('user.index') }}"
                                   class="dropdown-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                                   <i class="fa fa-users me-2" style="font-size:.75rem;"></i>Data Pengguna
                                </a>
                            @endcan
                        </div>
                    </div>
                @endif

            @else
                {{-- User Menu --}}
                <a href="{{ route('user.peminjaman.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}">
                    <i class="fa fa-history me-2"></i>Riwayat Peminjaman
                </a>
            @endif

        </div>

        {{-- ===== Logout at bottom ===== --}}
        <div class="mt-4 mx-3 w-100" style="padding-right:28px;">
            <div style="border-top:1px solid rgba(255,255,255,.08); padding-top:16px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            style="width:100%; background:rgba(239,68,68,.15); border:1px solid rgba(239,68,68,.3); color:#fca5a5; border-radius:12px; padding:10px 16px; font-size:.875rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:8px; transition:all .3s;"
                            onmouseover="this.style.background='rgba(239,68,68,.25)'"
                            onmouseout="this.style.background='rgba(239,68,68,.15)'">
                        <i class="fa fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

    </nav>
</div>