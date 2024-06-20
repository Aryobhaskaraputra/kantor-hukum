<div class="d-flex flex-column flex-shrink-0  sidebar">
    <div class="sidebar-content">
        <ul class="nav  flex-column mb-auto">
            <li class="nav-item">
                <a  href="{{ route('dashboard') }}" class="nav-link @if(request()->is('home')) active @endif" aria-current="page">
                    <img src="{{ asset('storage/images/dashboard-icon.svg') }}" class="m-2" alt="Dashboard Icon"
                        width="16" height="16">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kasus.index') }}" class="nav-link @if(request()->is('kasus')) active @endif" aria-current="page">
                    <img src="{{ asset('storage/images/list-icon.svg') }}" class="m-2" alt="Dashboard Icon"
                        width="16" height="16">
                    Kasus
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('team.index') }}" class="nav-link @if(request()->is('team')) active @endif" aria-current="page">
                    <img src="{{ asset('storage/images/team.svg') }}" class="m-2" alt="Dashboard Icon" width="16"
                        height="16">
                    Team
                </a>
            </li>
            @if (Auth::check() && (Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Master'))
            <li class="nav-item">
                <a href="{{ route('admin.list-pendaftar') }}" class="nav-link @if(request()->is('list-pendaftar')) active @endif" aria-current="page">
                    <img src="{{ asset('storage/images/management.svg') }}" class="m-2" alt="Dashboard Icon" width="16" height="16">
                    List Pendaftar
                </a>
            </li>
            @endif
            @if (Auth::check() && Auth::user()->role->role_name === 'Master')
            <li class="nav-item">
                <a href="{{ route('User Management Page') }}" class="nav-link @if(request()->is('user-management')) active @endif" aria-current="page">
                    <img src="{{ asset('storage/images/management.svg') }}" class="m-2" alt="Dashboard Icon" width="16" height="16">
                    Manajemen Pengguna
                </a>
            </li>
            @endif
        </ul>
        <hr>
        <div class="logout-container mt-auto">
            <a href="#" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="{{ asset('storage/images/logout-icon.svg') }}" alt="Logout Icon" width="16" height="16" class="me-2">
                Keluar
            </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div>
</div>
