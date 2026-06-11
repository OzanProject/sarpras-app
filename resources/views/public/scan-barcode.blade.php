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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

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

                    <div class="text-center mt-4 mb-4">
                        <a href="{{ url('/') }}" class="btn-home"><i class="fa fa-arrow-left me-2"></i>Kembali ke Beranda</a>
                    </div>

                    <hr class="my-4">

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($type !== 'kembali')
                        @if($barang->stok > 0)
                            <div class="card border-0 shadow-sm p-4 rounded-4" style="background-color: #ffffff;">
                                <h5 class="fw-bold mb-3"><i class="fa fa-hand-holding me-2"></i>Form Peminjaman</h5>
                                <form action="{{ route('public.pinjam') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nama Siswa / Peminjam</label>
                                        <input type="text" name="nama_peminjam" class="form-control form-control-lg" placeholder="Masukkan nama lengkap siswa" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Penanggung Jawab (Guru)</label>
                                        <select name="user_id" class="form-select select2" required>
                                            <option value="">Pilih Guru / Ketik untuk mencari...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Jumlah Pinjam</label>
                                        <input type="number" name="jumlah" class="form-control form-control-lg" value="1" min="1" max="{{ $barang->stok }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Keterangan / Keperluan</label>
                                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Untuk kegiatan OSIS"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Ajukan Peminjaman</button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="fa fa-info-circle me-2"></i>Maaf, stok barang sedang kosong sehingga tidak bisa dipinjam saat ini.
                            </div>
                        @endif
                    @endif

                    @if($type === 'kembali')
                        @if($activePeminjamans->count() > 0)
                            <div class="card border-0 shadow-sm p-4 rounded-4" style="background-color: #ffffff;">
                                <h5 class="fw-bold mb-3 text-success"><i class="fa fa-undo me-2"></i>Form Pengembalian</h5>
                                <form action="{{ route('public.kembali') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Siapa yang mengembalikan?</label>
                                        <select name="peminjaman_id" class="form-select select2" required>
                                            <option value="">Cari dan pilih nama peminjam...</option>
                                            @foreach($activePeminjamans as $pinjam)
                                                <option value="{{ $pinjam->id }}">{{ $pinjam->nama_peminjam }} ({{ $pinjam->jumlah }} Unit) - Dipinjam: {{ $pinjam->tgl_pinjam->format('d M Y') }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted d-block mt-1">Pilih nama Anda jika ingin mengembalikan barang ini.</small>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold"><i class="fa fa-check-circle me-2"></i>Kembalikan Barang</button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fa fa-check-circle me-2"></i>Tidak ada data peminjaman aktif untuk barang ini.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Nama / Ketik untuk mencari...',
            width: '100%'
        });
    });
</script>

</body>
</html>
