<nav class="navbar navbar-expand bg-white navbar-light sticky-top px-4 py-0" style="border-bottom: 1px solid #e0f2fe; box-shadow: 0 2px 12px rgba(14,165,233,.08);">
    <a href="{{ url('/') }}" class="navbar-brand d-flex d-lg-none me-4">
        @if(isset($global_settings['logo']) && $global_settings['logo'])
            <img src="{{ asset('storage/' . $global_settings['logo']) }}" class="rounded-circle" style="width: 35px; height: 35px;" alt="Logo">
        @else
            <h2 class="text-primary mb-0"><i class="fa fa-school"></i></h2>
        @endif
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0" style="color: #0ea5e9;">
        <i class="fa fa-bars"></i>
    </a>
    <form class="d-none d-md-flex ms-4">
        <input class="form-control" type="search" placeholder="Cari data..." style="background: #f0f9ff; border: 1px solid #e0f2fe; border-radius: 20px; min-width: 220px;">
    </form>
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('darkpan/img/user.jpg') }}" alt="" style="width: 40px; height: 40px; border: 2px solid #bae6fd;">
                <span class="d-none d-lg-inline-flex fw-semibold" style="color: #1e293b;">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 rounded-3 m-0" style="background: #fff; box-shadow: 0 8px 24px rgba(14,165,233,.15); border: 1px solid #e0f2fe;">
                <a href="{{ route('profile.edit') }}" class="dropdown-item" style="color: #1e293b;"><i class="fa fa-user-circle me-2 text-primary"></i>Profil Saya</a>
                <div class="dropdown-divider" style="border-color: #e0f2fe;"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item" style="color: #ef4444;"><i class="fa fa-sign-out-alt me-2"></i>Log Out</a>
                </form>
            </div>
        </div>
    </div>
</nav>
