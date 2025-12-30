<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="{{ url('/') }}" class="navbar-brand d-flex d-lg-none me-4">
        @if(isset($global_settings['logo']) && $global_settings['logo'])
            <img src="{{ asset('storage/' . $global_settings['logo']) }}" class="rounded-circle" style="width: 35px; height: 35px;" alt="Logo">
        @else
            <h2 class="text-primary mb-0"><i class="fa fa-school"></i></h2>
        @endif
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <form class="d-none d-md-flex ms-4">
        <input class="form-control bg-dark border-0" type="search" placeholder="Cari data...">
    </form>
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('darkpan/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">Log Out</a>
                </form>
            </div>
        </div>
    </div>
</nav>
