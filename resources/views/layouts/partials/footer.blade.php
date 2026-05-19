<div class="container-fluid pt-4 px-4">
    <div class="rounded-top p-4" style="background: #fff; border-top: 1px solid #e0f2fe;">
        <div class="row">
            <div class="col-12 col-sm-6 text-center text-sm-start" style="color: #64748b;">
                @if(isset($global_settings['footer_text']) && $global_settings['footer_text'])
                    {{ $global_settings['footer_text'] }}
                @else
                    &copy; <a href="#" style="color: #0ea5e9; text-decoration: none;">{{ $global_settings['nama_sekolah'] ?? 'Aplikasi Sarpras' }}</a>, All Right Reserved.
                @endif
            </div>
            <div class="col-12 col-sm-6 text-center text-sm-end" style="color: #64748b;">
                Designed By <a href="https://ozanproject.site/" target="_blank" style="color: #0ea5e9; text-decoration: none; font-weight: 600;">Ozan Project</a>
            </div>
        </div>
    </div>
</div>
