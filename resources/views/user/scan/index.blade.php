@extends('layouts.admin')

@section('title', 'Scan Pengembalian')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 justify-content-center">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4 text-center">
                <h6 class="mb-4">Scan QR Code Barang untuk Mengembalikan</h6>
                
                <div id="reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                
                <form action="{{ route('user.scan.process') }}" method="POST" id="scanForm" class="mt-4">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode Barang" required autofocus>
                        <label for="kode_barang">Kode Barang (Otomatis terisi saat scan)</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Proses Pengembalian</button>
                </form>

                @if(session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);
        
        // Fill input and submit
        document.getElementById('kode_barang').value = decodedText;
        document.getElementById('scanForm').submit();
        
        // Stop scanning
        html5QrcodeScanner.clear();
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection
