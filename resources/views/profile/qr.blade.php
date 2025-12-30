<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kartu Anggota - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            width: 350px;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-align: center;
            border: 2px solid #333;
            position: relative;
            overflow: hidden;
        }
        .header {
            background: #191C24; /* Darkpan secondary color approximation */
            color: #EB1616; /* Darkpan primary color approximation */
            padding: 15px;
            margin: -20px -20px 20px -20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #EB1616;
            margin-bottom: 15px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info h3 {
            margin: 0;
            color: #333;
            font-size: 22px;
        }
        .info p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        .qr-code {
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #999;
        }
        @media print {
            body {
                background: white;
            }
            .card {
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2>KARTU ANGGOTA SARPRAS</h2>
        </div>
        
        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('darkpan/img/user.jpg') }}" alt="Foto Profil" class="avatar">
        
        <div class="info">
            <h3>{{ $user->name }}</h3>
            <p>{{ $user->role == 'admin' ? 'Administrator' : 'Anggota Peminjam' }}</p>
            <p>{{ $user->email }}</p>
        </div>

        <div class="qr-code">
            <!-- Using Dynamic Loan Summary -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(\Illuminate\Support\Str::limit($loanSummary, 900)) }}" alt="QR Code" id="qrImage">
            <p style="font-size: 12px; margin-top: 5px;">Scan untuk Cek Status Barang</p>
        </div>

        <div class="footer">
            Kartu ini sah digunakan untuk peminjaman barang.
        </div>
    </div>
    <script>
        // Wait for image to load before printing
        document.getElementById('qrImage').onload = function() {
            setTimeout(function() {
                window.print();
            }, 500); // Small delay to ensure rendering
        };
        // Fallback if cached or fast load
        if (document.getElementById('qrImage').complete) {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
