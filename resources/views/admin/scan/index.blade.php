@extends('layouts.admin')

@section('title', 'Scan QR Code')

@section('content')
<div class="row">
    <div class="col-12 col-md-6 offset-md-3">
        <div class="bg-secondary rounded h-100 p-4 text-center">
            <h6 class="mb-4">Scan QR Code Barang</h6>
            
            <div id="reader" width="600px"></div>
            
            <p class="mt-3 text-muted">Arahkan kamera ke QR Code barang.</p>
            <div class="alert alert-warning d-none" id="https-warning">
                <small><i class="fa fa-exclamation-triangle me-2"></i>Kamera butuh <b>HTTPS</b> atau akses via <b>localhost</b>.</small>
            </div>
            <script>
                if (location.protocol !== "https:" && location.hostname !== "localhost" && location.hostname !== "127.0.0.1") {
                    document.getElementById('https-warning').classList.remove('d-none');
                }
            </script>
            
            <!-- Manual Input Fallback -->
            <hr class="my-4">
            <form action="{{ route('scan.process') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="kode_barang" class="form-control" placeholder="Atau masukkan Kode Barang manual..." required>
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if testing on non-secure context (HTTP)
        if (location.protocol !== "https:" && location.hostname !== "localhost" && location.hostname !== "127.0.0.1") {
            alert("Peringatan: Kamera mungkin tidak berjalan di HTTP biasa (bukan Localhost). Gunakan HTTPS atau localhost.");
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Scan result: ${decodedText}`, decodedResult);
            
            // Just submit directly. Page navigation will close the camera stream.
            let input = document.querySelector('input[name="kode_barang"]');
            if(input) {
                input.value = decodedText;
                input.closest('form').submit();
            } else {
                alert("Error: Input form not found.");
            }
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false);
        
        try {
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        } catch (e) {
            console.error(e);
            alert("Gagal menginisialisasi kamera. Pastikan izin kamera diberikan.");
        }
    });
</script>
@endpush
