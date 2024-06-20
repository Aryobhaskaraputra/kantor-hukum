<header class="navbar-header p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img src="{{ asset('storage/images/logo.svg') }}" alt="Logo" class="me-2">
        </a>
        <div class="text-end d-flex align-items-center">
            <a href="#" class="position-relative mx-3 " id="notificationDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="{{ asset('storage/images/Bell.svg') }}" alt="Bell Icon">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            </a>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications py-0"
                aria-labelledby="notificationDropdown">
                <li class="dropdown-header align-items-center p-3 fs-small">
                    <h5 class="text-center mb-0 fw-bold">Notifikasi</h5>
                </li>
                @if (auth()->user()->unreadNotifications->isEmpty())
                    <li class="notification-item d-flex align-items-center justify-content-center px-3 py-2">
                        <div class="py-2">
                            <p class="mb-0 text-muted text-center">Tidak ada notifikasi</p>
                        </div>
                    </li>
                @else
                    @foreach (auth()->user()->unreadNotifications as $notification)
                        <li class="notification-item d-flex align-items-start px-3 py-2">
                            <a href="{{ url($notification->data['url'] . '?id=' . $notification->id) }}">
                                <div class="py-2">
                                    <h6 class="mb-1 fw-bold">{{ $notification->data['title'] }}</h6>
                                    <p class="mb-1">{{ $notification->data['messages'] }}</p>
                                    <small class="mb-0 text-muted opacity-50">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    <li class="dropdown-footer text-center py-2">
                        <form id="mark-all-read-form" action="{{ route('notifications.markAllRead') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('mark-all-read-form').submit();">Tandai
                            semua sudah dibaca</a>
                    </li>
                @endif

            </ul>
            @if (Auth::check())
                <div class="dropdown">
                    <button class="btn btn-link p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('storage/' . (Auth::user()->profile_photo_url ?? 'images/profile-icon.svg')) }}"
                            alt="Profile Picture" width="32" height="32" class="rounded-circle">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item"
                            href="{{ route('profile.index', ['id' => Auth::user()->id]) }}">Profile</a>
                        <a class="dropdown-item" href="{{ route('change-password') }}">Ubah Password</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</header>
