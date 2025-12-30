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
        <p>Laporan Peminjaman Barang</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Pinjam</th>
                <th>Peminjam</th>
                <th>Nama Barang</th>
                <th>Kode</th>
                <th>Jml</th>
                <th>Status</th>
                <th>Tgl Kembali</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>

    <div style="margin-top: 40px; text-align: right; margin-right: 50px;">
        <p>{{ now()->translatedFormat('l, d F Y') }}</p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p>_________________________</p>
        <p>Kepala Sarpras</p>
    </div>
</body>
</html>
