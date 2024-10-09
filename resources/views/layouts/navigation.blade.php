<nav x-data="{ open: false }" class="bg-gradient-to-r from-gray-800 via-gray-700 to-gray-900 border-b border-gray-700">
    <!-- Flaming Header -->
    <div class="text-center py-4">
        <div class="relative inline-block">
            <h1 class="text-4xl font-bold text-white animate-blazing-title metal-frame">
                BURZ-VADOK
            </h1>
            <div class="absolute inset-0 border-4 border-gray-400 rounded-lg pointer-events-none metal-frame-border"></div>
        </div>
    </div>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ml-10 sm:flex">
                    <!-- Home Link -->
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('wecome')" class="text-white hover:text-gray-300 transition duration-200 flex items-center">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V9z" />
                        </svg>
                    </x-nav-link>
                
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-gray-300 transition duration-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- News Link -->
                    <x-nav-link :href="route('news')" :active="request()->routeIs('news')" class="text-white hover:text-gray-300 transition duration-200">
                        {{ __('News') }}
                    </x-nav-link>

                    <!-- Forum Link -->
                    <x-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.index')" class="text-white hover:text-gray-300 transition duration-200">
                        {{ __('Forum') }}
                    </x-nav-link>

                    <!-- Music Link -->
                    <x-nav-link :href="route('music.index')" :active="request()->routeIs('music.index')" class="text-white hover:text-gray-300 transition duration-200">
                        {{ __('Music') }}
                    </x-nav-link>

                    @can('adminAny', App\Models\ForumPost::class)
                    <!-- Admin Panel -->
                    <x-nav-link :href="route('adminforum.index')" :active="request()->routeIs('adminforum.index')" class="text-white hover:text-gray-300 transition duration-200">
                        {{ __('Admin') }}
                    </x-nav-link>
                    @endcan
                </div>
            </div>

            @if(Auth::user())
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-white hover:text-gray-300 focus:outline-none focus:text-gray-300 transition duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-800 hover:bg-gray-200">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-800 hover:bg-gray-200">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
            <a
                href="{{ route('login') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Log in
            </a>
            @endif

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Responsive Home Link -->
            <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')" class="text-white hover:bg-gray-700 flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V9z" />
                </svg>
            </x-responsive-nav-link>   
        
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-gray-700">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Responsive News Link -->
            <x-responsive-nav-link :href="route('news')" :active="request()->routeIs('news')" class="text-white hover:bg-gray-700">
                {{ __('News') }}
            </x-responsive-nav-link>

            <!-- Responsive Forum Link -->
            <x-responsive-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.index')" class="text-white hover:bg-gray-700">
                {{ __('Forum') }}
            </x-responsive-nav-link>

            <!-- Responsive Music Link -->
            <x-responsive-nav-link :href="route('music.index')" :active="request()->routeIs('music.index')" class="text-white hover:bg-gray-700">
                {{ __('Music') }}
            </x-responsive-nav-link>

            @can('adminAny', App\Models\ForumPost::class)
            <!-- Responsive Admin Link -->
            <x-responsive-nav-link :href="route('adminforum.index')" :active="request()->routeIs('adminforum.index')" class="text-white hover:bg-gray-700">
                {{ __('Admin') }}
            </x-responsive-nav-link>
            @endcan
        </div>

        @if(Auth::user())

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-gray-700">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white hover:bg-gray-700">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <a
            href="{{ route('login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Log in
        </a>
        @endif
    </div>
</nav>
