<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Scan QR Code - Public</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; }
        .scan-card { background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(14,165,233,.1); overflow: hidden; margin-top: 40px; margin-bottom: 40px; padding: 30px; text-align: center; }
        .btn-home { background: #f1f5f9; color: #0f172a; border-radius: 8px; font-weight: 600; padding: 10px 20px; text-decoration: none; display: inline-block; margin-top: 20px; }
        .btn-home:hover { background: #e2e8f0; color: #0f172a; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="scan-card">
                <h4 class="fw-bold mb-4"><i class="fa fa-qrcode me-2"></i>Scan QR Code {{ $type == 'kembali' ? 'Pengembalian' : 'Peminjaman' }}</h4>
                
                <div id="reader" width="100%"></div>
                
                <p class="mt-3 text-muted">Arahkan kamera ke QR Code yang tertempel di barang.</p>
                <div class="alert alert-warning d-none" id="https-warning">
                    <small><i class="fa fa-exclamation-triangle me-2"></i>Kamera butuh <b>HTTPS</b> atau akses via <b>localhost</b>.</small>
                </div>
                
                <form action="" id="manual-form" onsubmit="handleManualSubmit(event)" class="mt-4 text-start">
                    <label for="kode_manual" class="form-label fw-bold text-center w-100 mb-3">Atau pilih barang manual:</label>
                    <div class="mb-3">
                        <select id="kode_manual" class="form-select select2" required>
                            <option value="">Ketik nama atau kode barang...</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->kode_barang }}">{{ $barang->kode_barang }} - {{ $barang->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary w-100" type="submit"><i class="fa fa-search me-2"></i>Cari Barang</button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ url('/') }}" class="btn-home"><i class="fa fa-arrow-left me-2"></i>Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (location.protocol !== "https:" && location.hostname !== "localhost" && location.hostname !== "127.0.0.1") {
            document.getElementById('https-warning').classList.remove('d-none');
        }

        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Ketik nama atau kode barang...',
            width: '100%'
        });

        function onScanSuccess(decodedText, decodedResult) {
            let type = '{{ $type }}';
            // Jika hasil scan adalah URL (contoh: http://sarpas-app.test/scan-barcode/BRG-001)
            if (decodedText.startsWith('http://') || decodedText.startsWith('https://')) {
                let url = new URL(decodedText);
                let paths = url.pathname.split('/');
                let kode = paths[paths.length - 1];
                window.location.href = "{{ url('/scan-barcode') }}/" + kode + "?type=" + type;
            } else {
                // Jika hanya kode barang, arahkan ke route scan barcode
                window.location.href = "{{ url('/scan-barcode') }}/" + decodedText + "?type=" + type;
            }
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
        
        try {
            html5QrcodeScanner.render(onScanSuccess, function(){});
        } catch (e) {
            console.error(e);
        }
    });

    function handleManualSubmit(e) {
        e.preventDefault();
        let type = '{{ $type }}';
        let kode = document.getElementById('kode_manual').value;
        if(kode) {
            window.location.href = "{{ url('/scan-barcode') }}/" + kode + "?type=" + type;
        }
    }
</script>
</body>
</html>
