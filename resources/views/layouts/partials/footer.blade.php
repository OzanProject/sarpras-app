<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded-top p-4">
        <div class="row">
            <div class="col-12 col-sm-6 text-center text-sm-start">
                @if(isset($global_settings['footer_text']) && $global_settings['footer_text'])
                    {{ $global_settings['footer_text'] }}
                @else
                    &copy; <a href="#">{{ $global_settings['nama_sekolah'] ?? 'Aplikasi Sarpras' }}</a>, All Right Reserved.
                @endif
            </div>
            <div class="col-12 col-sm-6 text-center text-sm-end">
                Designed By <a href="https://ozanproject.site/" target="_blank">Ozan Project</a>
            </div>
        </div>
    </div>
</div>
