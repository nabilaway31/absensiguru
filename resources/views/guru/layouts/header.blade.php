<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-6 lg:px-8 py-2">
        <div class="flex items-center justify-between">
            <!-- Page Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    @yield('title', 'Dashboard')
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Portal Guru - Sistem Absensi
                </p>
            </div>

            <!-- User Info + Dropdown -->
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center text-sm text-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span id="current-date"></span>
                </div>

                <div class="relative">
                    <button id="user-btn" type="button"
                        class="flex items-center gap-3 text-gray-700 px-2 py-1 rounded hover:bg-gray-100"
                        onclick="toggleUserMenu()">
                        <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-xs opacity-90">Guru</p>
                        </div>
                        <svg id="user-chevron" class="w-4 h-4 text-gray-500 transform transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div id="user-menu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 origin-top-right transform transition ease-out duration-150 opacity-0 scale-95">
                        <div class="py-1">
                            <a href="{{ route('guru_user.profil') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            const chevron = document.getElementById('user-chevron');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                requestAnimationFrame(() => {
                    menu.classList.remove('opacity-0', 'scale-95');
                    menu.classList.add('opacity-100', 'scale-100');
                    if (chevron) chevron.classList.add('rotate-180');
                });
            } else {
                menu.classList.remove('opacity-100', 'scale-100');
                menu.classList.add('opacity-0', 'scale-95');
                if (chevron) chevron.classList.remove('rotate-180');
                const handler = function () {
                    menu.classList.add('hidden');
                    menu.removeEventListener('transitionend', handler);
                };
                menu.addEventListener('transitionend', handler);
            }
        }

        function closeUserMenu() {
            const menu = document.getElementById('user-menu');
            const chevron = document.getElementById('user-chevron');
            if (!menu || menu.classList.contains('hidden')) return;
            menu.classList.remove('opacity-100', 'scale-100');
            menu.classList.add('opacity-0', 'scale-95');
            if (chevron) chevron.classList.remove('rotate-180');
            const handler = function () {
                menu.classList.add('hidden');
                menu.removeEventListener('transitionend', handler);
            };
            menu.addEventListener('transitionend', handler);
        }

        window.addEventListener('click', function (e) {
            const btn = document.getElementById('user-btn');
            const menu = document.getElementById('user-menu');
            if (!btn || !menu) return;
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                closeUserMenu();
            }
        });

        (function () {
            const el = document.getElementById('current-date');
            if (!el) return;
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            el.textContent = new Date().toLocaleDateString('id-ID', options);
        })();
    </script>
</header>
