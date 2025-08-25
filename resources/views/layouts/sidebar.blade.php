<div class="p-4 border-b border-gray-200">
    <a href="{{ Auth::user()->role == 'admin' ? route('home') : route('dashboard') }}" class="block">
        <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="h-12 w-auto mx-auto">
    </a>
</div>

<nav class="flex-1 px-2 py-4 space-y-2">
    @if (Auth::user()->role == 'admin')
        {{-- Menu untuk Admin --}}
        <a href="{{ route('home') }}"
            class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('home') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            Home
        </a>

        <a href="{{ route('dashboard') }}"
            class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            Work Orders
        </a>

        <a href="{{ route('stock-opname.index') }}"
            class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('stock-opname.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                <path d="M20 10V5.5a2.5 2.5 0 0 0-5 0V10" />
                <path d="M20 10h-5" />
                <path d="M4 14V8.5a2.5 2.5 0 0 1 5 0V14" />
                <path d="M4 14h5" />
                <path d="M12 20v-5.5a2.5 2.5 0 0 1 5 0V20" />
                <path d="M12 20h5" />
            </svg>
            Stock Opname
        </a>

        <div class="space-y-1">
            <div class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.data-master') || request()->routeIs('overmate.*') || request()->routeIs('work-orders.data.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <a href="{{ route('admin.data-master') }}" class="flex items-center no-underline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                        <rect x="3" y="4" width="18" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="8" x2="16" y2="8"></line>
                        <line x1="8" y1="12" x2="12" y2="12"></line>
                    </svg>
                    <span>Data Master</span>
                </a>
                <button type="button" onclick="(function(){var el=document.getElementById('data-master-submenu');var chev=document.getElementById('data-master-chevron');if(!el) return; var hidden=el.classList.contains('hidden'); if(hidden){el.classList.remove('hidden'); if(chev) chev.style.transform='rotate(180deg)';} else {el.classList.add('hidden'); if(chev) chev.style.transform='rotate(0deg)';}})()" class="p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transform transition-transform" id="data-master-chevron">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </div>
            <div class="ml-4 space-y-1 {{ request()->routeIs('admin.data-master') || request()->routeIs('overmate.*') || request()->routeIs('work-orders.data.*') ? '' : 'hidden' }}" id="data-master-submenu">
                <a href="{{ route('overmate.index') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('overmate.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Overmate Data
                </a>
                <a href="{{ route('work-orders.data.index') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('work-orders.data.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Work Order Data
                </a>
            </div>
        </div>

        <div class="space-y-1">
            <div class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.settings.*') || request()->routeIs('settings.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <a href="{{ route('admin.settings.index') }}" class="flex items-center no-underline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="mr-3">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82V9a1.65 1.65 0 0 0 1.51-1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z">
                        </path>
                    </svg>
                    <span>Settings</span>
                </a>
                <button type="button" onclick="toggleSettingsDropdown()" class="p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="transform transition-transform" id="settings-chevron">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </div>
            <div class="ml-4 space-y-1 {{ request()->routeIs('admin.settings.*') || request()->routeIs('settings.*') ? '' : 'hidden' }}"
                id="settings-submenu">
                <a href="{{ route('settings.edit') }}"
                    class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('settings.edit') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Work Order Setting
                </a>
                <a href="{{ route('admin.settings.users') }}"
                    class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.settings.users*') || request()->is('settings/users*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    User Management
                </a>
            </div>
        </div>
        <div class="mt-6 px-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    @else
        {{-- Menu untuk User Biasa --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tracking-submenu" role="button"
                aria-expanded="false" aria-controls="tracking-submenu">
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
        <div class="mt-6 px-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    @endif
