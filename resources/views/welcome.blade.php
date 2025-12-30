<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Katalog Sarana Prasarana</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="{{ (isset($global_settings['logo']) && $global_settings['logo']) ? asset('storage/' . $global_settings['logo']) : asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('darkpan/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('darkpan/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('darkpan/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('darkpan/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        
        <!-- Content Start -->
        <div class="container-fluid cf-content p-0">
            
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg bg-secondary navbar-dark sticky-top px-4 py-3">
                <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
                    @if(isset($global_settings['logo']) && $global_settings['logo'])
                        <img src="{{ asset('storage/' . $global_settings['logo']) }}" alt="Logo" style="height: 40px; margin-right: 10px;">
                    @else
                        <h3 class="text-primary"><i class="fa fa-university me-2"></i></h3>
                    @endif
                    <h3 class="text-primary mb-0">{{ $global_settings['school_name'] ?? 'Sarana Prasarana' }}</h3>
                </a>
                
                <div class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login Staff</a>
                        @endauth
                    @endif
                </div>
            </nav>

            <!-- Hero / Search Section -->
            <div class="container-fluid pt-5 px-4 mb-5">
                <div class="row g-4 justify-content-center">
                    <div class="col-sm-12 col-xl-8 text-center">
                        <h1 class="display-4 text-primary mb-4">Cari Sarana & Prasarana</h1>
                        <p class="mb-4">Cek ketersediaan barang, lokasi, dan stok secara real-time.</p>
                        
                        <form action="{{ route('home') }}" method="GET">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" name="search" placeholder="Cari nama barang (contoh: Proyektor, Kamera)..." value="{{ $search }}">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search me-2"></i>Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Items Grid -->
            <div class="container-fluid px-4">
                <div class="row g-4">
                    @forelse($barangs as $barang)
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="bg-secondary rounded h-100 p-4 d-flex flex-column">
                            <div class="text-center mb-4">
                                @if($barang->foto)
                                    <img src="{{ asset('storage/' . $barang->foto) }}" class="img-fluid rounded" alt="{{ $barang->nama }}" style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-dark rounded d-flex align-items-center justify-content-center mx-auto" style="height: 150px; width: 100%;">
                                        <span class="text-muted"><i class="fa fa-image fa-2x"></i></span>
                                    </div>
                                @endif
                            </div>
                            <h5 class="mb-1 text-truncate" title="{{ $barang->nama }}">{{ $barang->nama }}</h5>
                            <p class="mb-2 text-muted small">{{ $barang->kode_barang }}</p>
                            
                            <div class="mb-3">
                                <span class="badge bg-dark border border-secondary">{{ $barang->kategori->nama }}</span>
                                <span class="badge bg-dark border border-secondary"><i class="fa fa-map-marker-alt me-1"></i> {{ $barang->room->nama ?? '-' }}</span>
                            </div>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div>
                                    <small>Stok:</small> 
                                    <h6 class="mb-0 {{ $barang->stok > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $barang->stok }} Unit
                                    </h6>
                                </div>

                                <div>
                                    @if($barang->stok > 0)
                                        @auth
                                            <form action="{{ route('user.peminjaman.store') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Ajukan peminjaman untuk barang ini?')">
                                                    <i class="fa fa-handshake me-1"></i> Pinjam
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login utk Pinjam</a>
                                        @endauth
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">Barang tidak ditemukan.</h4>
                        <a href="{{ route('home') }}" class="btn btn-outline-light mt-3">Reset Pencarian</a>
                    </div>
                    @endforelse
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $barangs->links() }}
                </div>
            </div>

            <!-- Footer -->
            <div class="container-fluid pt-4 px-4 mt-5">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 text-center text-sm-start text-muted">
                            &copy; {{ date('Y') }} <a href="#">{{ $global_settings['school_name'] ?? 'Sarana Prasarana' }}</a>. All Right Reserved. 
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('darkpan/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('darkpan/js/main.js') }}"></script>
</body>

</html>
