<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Code Barang</title>
    <style>
        @media print {
            body { 
                -webkit-print-color-adjust: exact; 
                margin: 0;
                padding: 10px;
            }
            .no-print { display: none; }
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #eee;
        }

        .page-container {
            width: 210mm; /* A4 width */
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 10mm;
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columns */
            grid-auto-rows: 55mm; /* Fixed height for ID card size */
            gap: 5mm;
            box-sizing: border-box;
        }

        .card {
            border: 1px solid #000;
            padding: 10px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .card-border-decoration {
            position: absolute;
            top: 0; left: 0; bottom: 0;
            width: 10px;
            background: #EB1616; /* Primary Color */
        }

        .qr-box {
            width: 120px;
            height: 120px;
            margin-left: 15px;
            flex-shrink: 0;
        }

        .qr-box img {
            width: 100%;
            height: 100%;
        }

        .info-box {
            margin-left: 20px;
            flex-grow: 1;
        }

        .school-name {
            font-size: 12px;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .item-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .item-code {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            background: #000;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .item-category {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .print-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <button class="no-print print-btn" onclick="window.print()">Cetak / Simpan PDF</button>

    <div class="page-container">
        @foreach($barangs as $barang)
        <div class="card">
            <div class="card-border-decoration"></div>
            <div class="qr-box">
                <!-- Using fixed size for print stability -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $barang->kode_barang }}" alt="QR">
            </div>
            <div class="info-box">
                <div class="school-name">Sarana Prasarana Sekolah</div>
                <div class="item-name">{{ Str::limit($barang->nama, 25) }}</div>
                <div class="item-code">{{ $barang->kode_barang }}</div>
                <div class="item-category">{{ $barang->kategori->nama }}</div>
            </div>
        </div>
        @endforeach
    </div>

</body>
</html>
