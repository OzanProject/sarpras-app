<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Katalog Sarana Prasarana - {{ $global_settings['school_name'] ?? 'Sekolah' }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Katalog digital sarana dan prasarana sekolah. Cek ketersediaan barang, lokasi, dan stok secara real-time.">

    <!-- Favicon -->
    <link href="{{ (isset($global_settings['logo']) && $global_settings['logo']) ? asset('storage/' . $global_settings['logo']) : asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="{{ asset('darkpan/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary:      #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light:#bae6fd;
            --accent:       #06b6d4;
            --bg:           #f0f9ff;
            --surface:      #ffffff;
            --border:       #e0f2fe;
            --text:         #1e293b;
            --text-muted:   #64748b;
            --success:      #10b981;
            --warning:      #f59e0b;
            --danger:       #ef4444;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
        }

        /* ===== NAVBAR ===== */
        .cf-navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 16px rgba(14,165,233,.10);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 14px 32px;
        }

        .cf-navbar .brand-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cf-navbar .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: .9rem;
            text-decoration: none;
            transition: all .3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-dark), #0891b2);
            color: #fff;
            box-shadow: 0 4px 14px rgba(14,165,233,.35);
            transform: translateY(-1px);
        }

        /* ===== HERO ===== */
        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0c4a6e 100%);
            padding: 72px 32px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14,165,233,.25) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(6,182,212,.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-section .hero-content {
            position: relative;
            z-index: 1;
            max-width: 680px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(14,165,233,.2);
            border: 1px solid rgba(14,165,233,.4);
            color: #7dd3fc;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: .8rem;
            font-weight: 600;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #7dd3fc, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            color: #94a3b8;
            font-size: 1.05rem;
            margin-bottom: 32px;
        }

        /* Search Box */
        .search-box {
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 16px;
            padding: 8px 8px 8px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 580px;
            margin: 0 auto;
        }

        .search-box input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 1rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .search-box input::placeholder { color: #94a3b8; }

        .search-box .btn-search {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            font-size: .95rem;
            cursor: pointer;
            transition: all .3s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .search-box .btn-search:hover {
            background: linear-gradient(135deg, var(--primary-dark), #0891b2);
            box-shadow: 0 4px 14px rgba(14,165,233,.4);
        }

        /* ===== STATS BAR ===== */
        .stats-bar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
        }

        .stat-value {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--text);
            line-height: 1;
        }

        .stat-label {
            font-size: .78rem;
            color: var(--text-muted);
        }

        /* ===== ITEM GRID ===== */
        .items-section { padding: 40px 32px 60px; }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        .section-title span {
            color: var(--primary);
        }

        .items-count {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: .8rem;
            font-weight: 600;
        }

        /* Item Card */
        .item-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: all .35s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .item-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(14,165,233,.16);
            border-color: var(--primary-light);
        }

        .item-img-wrap {
            height: 170px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, #e0f2fe, #f0f9ff);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s;
        }

        .item-card:hover .item-img-wrap img { transform: scale(1.06); }

        .item-img-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #93c5fd;
            width: 100%;
            height: 100%;
        }

        .item-img-placeholder i { font-size: 2.5rem; }
        .item-img-placeholder span { font-size: .78rem; color: #93c5fd; }

        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: .72rem;
            font-weight: 700;
        }

        .stock-ok    { background: rgba(16,185,129,.15); color: #065f46; border: 1px solid rgba(16,185,129,.3); }
        .stock-empty { background: rgba(239,68,68,.15);  color: #991b1b; border: 1px solid rgba(239,68,68,.3); }

        .item-body {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .item-name {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text);
            margin: 0 0 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .item-code {
            font-size: .78rem;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .item-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 14px;
        }

        .item-tag {
            background: #f0f9ff;
            color: #0284c7;
            border: 1px solid #bae6fd;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: .75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .item-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .item-stock {
            display: flex;
            flex-direction: column;
        }

        .item-stock .label { font-size: .72rem; color: var(--text-muted); }
        .item-stock .value { font-weight: 700; font-size: 1rem; }
        .item-stock .value.ok    { color: var(--success); }
        .item-stock .value.empty { color: var(--danger); }

        .btn-pinjam {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all .3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-pinjam:hover {
            background: linear-gradient(135deg, var(--primary-dark), #0891b2);
            color: #fff;
            box-shadow: 0 4px 12px rgba(14,165,233,.35);
        }

        .btn-login-pinjam {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            border-radius: 8px;
            padding: 6px 14px;
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-login-pinjam:hover {
            background: var(--primary);
            color: #fff;
        }

        .badge-habis {
            background: #fef2f2;
            color: var(--danger);
            border: 1px solid #fecaca;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 600;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 64px 24px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: #f0f9ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary);
            font-size: 2rem;
        }

        .empty-state h4 { color: var(--text); font-weight: 700; }
        .empty-state p  { color: var(--text-muted); }

        /* ===== FOOTER ===== */
        .cf-footer {
            background: #fff;
            border-top: 1px solid var(--border);
            padding: 20px 32px;
            text-align: center;
            color: var(--text-muted);
            font-size: .875rem;
        }

        .cf-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .cf-footer a:hover { color: var(--primary-dark); }

        /* Pagination */
        .pagination .page-link {
            color: var(--primary);
            border-color: var(--border);
            background: #fff;
            border-radius: 8px;
            margin: 0 2px;
            font-weight: 500;
        }
        .pagination .page-link:hover {
            background: #f0f9ff;
            color: var(--primary-dark);
            border-color: var(--primary-light);
        }
        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="cf-navbar d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="brand-name">
            @if(isset($global_settings['logo']) && $global_settings['logo'])
                <img src="{{ asset('storage/' . $global_settings['logo']) }}" alt="Logo"
                     style="height: 36px; width: 36px; border-radius: 8px; object-fit: cover;">
            @else
                <div class="brand-icon">
                    <i class="fa fa-university"></i>
                </div>
            @endif
            <span>{{ $global_settings['school_name'] ?? 'Sarana Prasarana' }}</span>
        </a>

        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-login">
                        <i class="fa fa-th-large"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">
                        <i class="fa fa-sign-in-alt"></i> Login Staff
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fa fa-circle" style="font-size:.5rem; color:#4ade80;"></i>
                Sistem Informasi Sarana Prasarana
            </div>
            <h1 class="hero-title">
                Cari <span>Sarana & Prasarana</span><br>Sekolah dengan Mudah
            </h1>
            <p class="hero-subtitle">
                Cek ketersediaan barang, lokasi ruangan, dan stok secara real-time.
            </p>

            <form action="{{ route('home') }}" method="GET">
                <div class="search-box">
                    <i class="fa fa-search" style="color:#94a3b8;"></i>
                    <input type="text" name="search"
                           placeholder="Cari nama barang (contoh: Proyektor, Kamera)..."
                           value="{{ $search }}">
                    <button type="submit" class="btn-search">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== ITEMS SECTION ===== -->
    <div class="items-section">
        <div class="section-header">
            <h2 class="section-title">
                Daftar <span>Barang</span> Tersedia
            </h2>
            @if($search)
                <span class="items-count">
                    <i class="fa fa-filter me-1"></i>Filter: "{{ $search }}"
                </span>
            @else
                <span class="items-count">
                    {{ $barangs->total() }} Barang
                </span>
            @endif
        </div>

        <div class="row g-4">
            @forelse($barangs as $barang)
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                <div class="item-card">
                    <!-- Image -->
                    <div class="item-img-wrap">
                        @if($barang->foto)
                            <img src="{{ asset('storage/' . $barang->foto) }}"
                                 alt="{{ $barang->nama }}">
                        @else
                            <div class="item-img-placeholder">
                                <i class="fa fa-box-open"></i>
                                <span>Belum ada foto</span>
                            </div>
                        @endif
                        <!-- Stock badge on image -->
                        @if($barang->stok > 0)
                            <span class="stock-badge stock-ok">
                                <i class="fa fa-check-circle me-1"></i>Tersedia
                            </span>
                        @else
                            <span class="stock-badge stock-empty">
                                <i class="fa fa-times-circle me-1"></i>Habis
                            </span>
                        @endif
                    </div>

                    <!-- Body -->
                    <div class="item-body">
                        <h5 class="item-name" title="{{ $barang->nama }}">{{ $barang->nama }}</h5>
                        <p class="item-code">
                            <i class="fa fa-barcode me-1"></i>{{ $barang->kode_barang }}
                        </p>

                        <div class="item-tags">
                            <span class="item-tag">
                                <i class="fa fa-tag"></i>{{ $barang->kategori->nama }}
                            </span>
                            <span class="item-tag">
                                <i class="fa fa-map-marker-alt"></i>{{ $barang->room->nama ?? 'Belum ditentukan' }}
                            </span>
                        </div>

                        <div class="item-footer">
                            <div class="item-stock">
                                <span class="label">Stok tersedia</span>
                                <span class="value {{ $barang->stok > 0 ? 'ok' : 'empty' }}">
                                    {{ $barang->stok }} Unit
                                </span>
                            </div>

                            <div>
                                @if($barang->stok > 0)
                                    @auth
                                        <form action="{{ route('user.peminjaman.store') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                                            <button type="submit" class="btn-pinjam"
                                                onclick="return confirm('Ajukan peminjaman untuk {{ $barang->nama }}?')">
                                                <i class="fa fa-handshake"></i> Pinjam
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-login-pinjam">
                                            <i class="fa fa-lock"></i> Login
                                        </a>
                                    @endauth
                                @else
                                    <span class="badge-habis">
                                        <i class="fa fa-times me-1"></i>Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa fa-search"></i>
                    </div>
                    <h4>Barang tidak ditemukan</h4>
                    <p>Coba kata kunci lain atau reset pencarian Anda.</p>
                    <a href="{{ route('home') }}" class="btn-pinjam" style="display: inline-flex;">
                        <i class="fa fa-redo"></i> Reset Pencarian
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $barangs->links() }}
        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="cf-footer">
        &copy; {{ date('Y') }}
        <a href="#">{{ $global_settings['school_name'] ?? 'Sarana Prasarana' }}</a>.
        All Rights Reserved. &nbsp;·&nbsp; Designed by
        <a href="https://ozanproject.site/" target="_blank">Ozan Project</a>
    </footer>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
