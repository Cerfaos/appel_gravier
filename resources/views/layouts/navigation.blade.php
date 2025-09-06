<!-- Outdoor Dashboard Navigation -->
<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-md border-b border-outdoor-cream-200 sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Outdoor Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 bg-outdoor-olive-500 rounded-xl text-white">
                            <span class="text-xl">🌿</span>
                        </div>
                        <div class="hidden sm:block">
                            <div class="font-display font-bold text-lg text-outdoor-forest-600">Cerfaos</div>
                            <div class="text-xs text-outdoor-forest-400">Dashboard Outdoor</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-outdoor-olive-100 text-outdoor-olive-700' : 'text-outdoor-forest-600 hover:text-outdoor-olive-600 hover:bg-outdoor-cream-100' }}"
                    >
                        <span class="text-lg mr-2">🏔️</span>
                        {{ __('Dashboard') }}
                    </a>
                    
                    <a 
                        href="{{ url('/') }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl text-outdoor-forest-600 hover:text-outdoor-olive-600 hover:bg-outdoor-cream-100 transition-all duration-300"
                    >
                        <span class="text-lg mr-2">🏠</span>
                        Site Public
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-outdoor-cream-300 text-sm leading-4 font-medium rounded-xl text-outdoor-forest-600 bg-white hover:text-outdoor-olive-600 hover:border-outdoor-olive-300 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 transition ease-in-out duration-150">
                            <div class="w-8 h-8 bg-outdoor-olive-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-outdoor-olive-600 font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-outdoor-forest-400">Membre Cerfaos</div>
                            </div>

                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="py-2">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2 text-outdoor-forest-600 hover:text-outdoor-olive-600 hover:bg-outdoor-cream-50">
                                <span class="text-lg">👤</span>
                                <span>{{ __('Profile') }}</span>
                            </x-dropdown-link>

                            <div class="border-t border-outdoor-cream-200 my-2"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center space-x-2 text-red-600 hover:text-red-700 hover:bg-red-50">
                                    <span class="text-lg">🚪</span>
                                    <span>{{ __('Déconnexion') }}</span>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-outdoor-forest-400 hover:text-outdoor-forest-600 hover:bg-outdoor-cream-100 focus:outline-none focus:bg-outdoor-cream-100 focus:text-outdoor-forest-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-outdoor-cream-200">
        <div class="pt-4 pb-3 space-y-2 px-4">
            <a 
                href="{{ route('dashboard') }}" 
                class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-outdoor-olive-100 text-outdoor-olive-700' : 'text-outdoor-forest-600 hover:text-outdoor-olive-600 hover:bg-outdoor-cream-100' }}"
            >
                <span class="text-xl">🏔️</span>
                <span>{{ __('Dashboard') }}</span>
            </a>
            
            <a 
                href="{{ url('/') }}" 
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-outdoor-forest-600 hover:text-outdoor-olive-600 hover:bg-outdoor-cream-100 font-medium transition-colors"
            >
                <span class="text-xl">🏠</span>
                <span>Site Public</span>
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-outdoor-cream-200 bg-outdoor-cream-50">
            <div class="px-4 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-outdoor-olive-100 rounded-full flex items-center justify-center">
                        <span class="text-outdoor-olive-600 font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <div class="font-medium text-base text-outdoor-forest-600">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-outdoor-forest-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-2 px-4 pb-4">
                <a 
                    href="{{ route('profile.edit') }}" 
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl text-outdoor-forest-600 hover:text-outdoor-olive-600 hover:bg-white font-medium transition-colors"
                >
                    <span class="text-xl">👤</span>
                    <span>{{ __('Profile') }}</span>
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button 
                        type="submit"
                        class="flex items-center space-x-3 px-4 py-3 rounded-xl text-red-600 hover:text-red-700 hover:bg-red-50 font-medium transition-colors w-full text-left"
                    >
                        <span class="text-xl">🚪</span>
                        <span>{{ __('Déconnexion') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
