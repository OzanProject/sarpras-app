<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Detail Barang - {{ $barang->nama }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="{{ asset('darkpan/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f9ff;
            color: #1e293b;
        }
        .detail-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(14,165,233,.1);
            overflow: hidden;
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .header-bg {
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            padding: 20px;
            color: white;
            text-align: center;
        }
        .header-bg h4 {
            margin: 0;
            font-weight: 700;
            color: white;
        }
        .img-container {
            text-align: center;
            padding: 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .img-container img {
            max-height: 250px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .info-table th {
            width: 35%;
            color: #64748b;
            font-weight: 600;
        }
        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .btn-home {
            background: #f1f5f9;
            color: #0f172a;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-home:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="detail-card">
                <div class="header-bg">
                    <h4><i class="fa fa-box-open me-2"></i>Informasi Barang</h4>
                </div>
                
                <div class="img-container">
                    @if($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" class="img-fluid" alt="{{ $barang->nama }}">
                    @else
                        <div class="py-5 text-muted">
                            <i class="fa fa-camera fa-3x mb-3"></i>
                            <p>Tidak ada foto</p>
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <h5 class="fw-bold mb-4 text-center">{{ $barang->nama }}</h5>
                    
                    <table class="table table-borderless info-table">
                        <tbody>
                            <tr>
                                <th>Kode Barang</th>
                                <td><span class="badge bg-dark">{{ $barang->kode_barang }}</span></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $barang->kategori->nama }}</td>
                            </tr>
                            <tr>
                                <th>Stok Tersedia</th>
                                <td><span class="fw-bold fs-5 {{ $barang->stok > 0 ? 'text-success' : 'text-danger' }}">{{ $barang->stok }}</span> Unit</td>
                            </tr>
                            <tr>
                                <th>Kondisi</th>
                                <td>
                                    @if($barang->kondisi == 'baik')
                                        <span class="badge badge-status bg-success">Baik</span>
                                    @elseif($barang->kondisi == 'rusak')
                                        <span class="badge badge-status bg-danger">Rusak</span>
                                    @else
                                        <span class="badge badge-status bg-warning text-dark">Perbaikan</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Lokasi / Ruangan</th>
                                <td>{{ $barang->room->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>PJ Ruangan</th>
                                <td>{{ $barang->room->pj_ruangan ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-4">
                        <a href="{{ url('/') }}" class="btn-home"><i class="fa fa-arrow-left me-2"></i>Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
