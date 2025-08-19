<div class="sidebar-header">
    <a href="{{ Auth::user()->role == 'admin' ? route('home') : route('dashboard') }}">
        <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="sidebar-logo">
    </a>
</div>

<ul class="nav flex-column sidebar-nav">
    @if (Auth::user()->role == 'admin')
        {{-- Menu untuk Admin --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                href="{{ route('settings.edit') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path
                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z">
                    </path>
                </svg>
                Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                Work Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                User Management
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('stock-opname.*') ? 'active' : '' }}"
                href="{{ route('stock-opname.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 10V5.5a2.5 2.5 0 0 0-5 0V10" />
                    <path d="M20 10h-5" />
                    <path d="M4 14V8.5a2.5 2.5 0 0 1 5 0V14" />
                    <path d="M4 14h5" />
                    <path d="M12 20v-5.5a2.5 2.5 0 0 1 5 0V20" />
                    <path d="M12 20h5" />
                </svg>
                Stock Opname
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('overmate.*') ? 'active' : '' }}"
                href="{{ route('overmate.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18" />
                    <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3" />
                </svg>
                Master Overmate
            </a>
        </li>
    @else
        {{-- Menu untuk User Biasa --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tracking-submenu" role="button" aria-expanded="false"
                aria-controls="tracking-submenu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                Tracking WO
            </a>
            <div class="collapse" id="tracking-submenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard', ['status' => 'On Progress']) }}">Dalam
                            Pengerjaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard', ['status' => 'Completed']) }}">Selesai</a>
                    </li>
                </ul>
            </div>
        </li>
    @endif
</ul>
