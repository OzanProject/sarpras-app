<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .no-print { display: none; }
        @media print {
            .no-print { display: block; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>{{ $global_settings['nama_sekolah'] ?? 'SARANA PRASARANA SEKOLAH' }}</h2>
        @if($type == 'peminjaman')
            <p>Laporan Peminjaman Barang</p>
            <p>Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
        @else
            <p>Laporan Total Aset / Barang Keseluruhan</p>
            <p>Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                @if($type == 'peminjaman')
                    <th>Tgl Pinjam</th>
                    <th>Peminjam</th>
                    <th>Nama Barang</th>
                    <th>Kode</th>
                    <th>Jml</th>
                    <th>Status</th>
                    <th>Tgl Kembali</th>
                    <th>Keterangan</th>
                @else
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                    <th>Lokasi / Ruangan</th>
                    <th>PJ Ruangan</th>
                    <th>Bukti Kerusakan</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if($type == 'peminjaman')
                @foreach($peminjamans as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ $item->nama_peminjam }}</td>
                    <td>{{ $item->barang->nama ?? '-' }}</td>
                    <td>{{ $item->barang->kode_barang ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @endforeach
            @else
                @foreach($barangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ $barang->kategori->nama ?? '-' }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>{{ ucfirst($barang->kondisi) }}</td>
                    <td>{{ $barang->room->nama ?? '-' }}</td>
                    <td>{{ $barang->room->pj_ruangan ?? '-' }}</td>
                    <td style="text-align: center;">
                        @if(($barang->kondisi == 'rusak' || $barang->kondisi == 'perbaikan') && $barang->maintenances->count() > 0)
                            <img src="{{ asset('storage/' . $barang->maintenances->first()->foto_bukti) }}" alt="Bukti" style="height: 60px; object-fit: cover;">
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div style="margin-top: 50px; width: 100%;">
        @if($type == 'peminjaman')
        <div style="float: right; text-align: center; margin-right: 50px;">
            <p>{{ now()->translatedFormat('l, d F Y') }}</p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p>_________________________</p>
            <p>Kepala Sarpras</p>
        </div>
        @else
        <div style="float: left; text-align: center; margin-left: 50px;">
            <p>&nbsp;</p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p>_________________________</p>
            <p>Kepala Sekolah</p>
        </div>
        <div style="float: right; text-align: center; margin-right: 50px;">
            <p>{{ now()->translatedFormat('l, d F Y') }}</p>
            <p>Pengurus Barang,</p>
            <br><br><br>
            <p>_________________________</p>
            <p>Nama Pengurus</p>
        </div>
        <div style="clear: both;"></div>
        @endif
    </div>
</body>
</html>
