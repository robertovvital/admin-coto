<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Coto') | Admin Coto</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- Navbar responsive (Componente Tailwind #1) --}}
    <nav class="bg-white shadow-sm border-b border-gray-200" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                {{-- Logo y navegación principal --}}
                <div class="flex items-center">
                    {{-- Logo --}}
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 mr-8">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-gray-900">Admin Coto</span>
                    </a>

                    {{-- Links de navegación (desktop) --}}
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('dashboard') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                                  {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('cotos.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                                  {{ request()->routeIs('cotos.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Cotos
                        </a>
                        <a href="{{ route('residentes.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                                  {{ request()->routeIs('residentes.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Residentes
                        </a>
                        <a href="{{ route('pagos.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                                  {{ request()->routeIs('pagos.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Pagos
                        </a>
                        <a href="{{ route('pagos.adeudos') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                                  {{ request()->routeIs('pagos.adeudos') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Adeudos
                        </a>
                        <a href="{{ route('reportes.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                                  {{ request()->routeIs('reportes.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Reportes
                        </a>
                    </div>
                </div>

                {{-- Usuario y logout (desktop) --}}
                <div class="hidden md:flex items-center space-x-3">
                    <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    <span class="badge-info">{{ ucfirst(auth()->user()->role) }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm text-gray-500 hover:text-red-600 transition-colors duration-150">
                            Salir
                        </button>
                    </form>
                </div>

                {{-- Botón hamburguesa (mobile) --}}
                <div class="flex items-center md:hidden">
                    <button @click="open = !open"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Menú mobile --}}
        <div x-show="open" x-transition class="md:hidden border-t border-gray-200 bg-white">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">Dashboard</a>
                <a href="{{ route('cotos.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">Cotos</a>
                <a href="{{ route('residentes.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">Residentes</a>
                <a href="{{ route('pagos.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">Pagos</a>
                <a href="{{ route('pagos.adeudos') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">Adeudos</a>
                <a href="{{ route('reportes.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">Reportes</a>
                <div class="pt-2 border-t border-gray-200">
                    <p class="px-3 py-1 text-xs text-gray-500">{{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Encabezado de página --}}
        @hasSection('header')
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">@yield('header')</h1>
                @hasSection('subheader')
                <p class="mt-1 text-sm text-gray-500">@yield('subheader')</p>
                @endif
            </div>
            @hasSection('actions')
            <div class="flex items-center space-x-3">
                @yield('actions')
            </div>
            @endif
        </div>
        @endif

        {{-- Alertas de sesión --}}
        @if (session('success'))
        <div class="mb-6 flex items-center p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 flex items-center p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm0-4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
