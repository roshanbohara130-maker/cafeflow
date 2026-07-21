<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CafeFlow</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800 antialiased">

    {{-- Nav --}}
    <header class="border-b border-stone-100 bg-white">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-amber-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9h13.5a3.75 3.75 0 010 7.5h-.75m-12.75-7.5v7.5A2.25 2.25 0 006 18.75h6.75A2.25 2.25 0 0015 16.5V9m-12 0V6.75A1.5 1.5 0 014.5 5.25h9A1.5 1.5 0 0115 6.75V9" />
                    </svg>
                </div>
                <span class="font-semibold text-lg text-stone-800">CafeFlow</span>
            </div>

            @if (Route::has('login'))
                <div class="flex items-center gap-4 text-sm">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-stone-600 hover:text-stone-900 font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-stone-600 hover:text-stone-900 font-medium">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-amber-700 hover:bg-amber-800 text-white font-medium px-4 py-2 rounded-lg transition">
                                Sign up
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </header>

    {{-- Hero --}}
    <main>
        <section class="max-w-5xl mx-auto px-6 py-20 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-amber-100 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9h13.5a3.75 3.75 0 010 7.5h-.75m-12.75-7.5v7.5A2.25 2.25 0 006 18.75h6.75A2.25 2.25 0 0015 16.5V9m-12 0V6.75A1.5 1.5 0 014.5 5.25h9A1.5 1.5 0 0115 6.75V9" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M11.25 3v1.5" />
                </svg>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold text-stone-800 tracking-tight">
                Welcome to CafeFlow
            </h1>
            <p class="mt-4 text-lg text-stone-500 max-w-xl mx-auto">
                Everything you need to run your cafe, in one simple place.
            </p>

            @guest
                <div class="mt-8 flex items-center justify-center gap-3">
                    <a href="{{ route('login') }}" class="bg-amber-700 hover:bg-amber-800 text-white font-medium px-6 py-2.5 rounded-lg shadow-sm transition">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="border border-stone-200 hover:border-stone-300 text-stone-700 font-medium px-6 py-2.5 rounded-lg transition">
                            Sign up
                        </a>
                    @endif
                </div>
            @endguest
        </section>

        {{-- Features --}}
        <section class="max-w-5xl mx-auto px-6 pb-20">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <div class="bg-white rounded-xl border border-stone-100 shadow-sm p-6">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 8.25v10.5A2.25 2.25 0 004.5 21h15a2.25 2.25 0 002.25-2.25V8.25M2.25 8.25l1.5-4.5h16.5l1.5 4.5" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-stone-800">Order Management</h3>
                    <p class="text-sm text-stone-500 mt-1.5">Take and track orders from one simple screen.</p>
                </div>

                <div class="bg-white rounded-xl border border-stone-100 shadow-sm p-6">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-stone-800">Table Tracking</h3>
                    <p class="text-sm text-stone-500 mt-1.5">See which tables are open at a glance.</p>
                </div>

                <div class="bg-white rounded-xl border border-stone-100 shadow-sm p-6">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-stone-800">Inventory</h3>
                    <p class="text-sm text-stone-500 mt-1.5">Keep stock levels up to date without the guesswork.</p>
                </div>

            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-stone-100 py-6">
        <p class="text-center text-xs text-stone-400">
            &copy; {{ date('Y') }} CafeFlow. All rights reserved.
        </p>
    </footer>

</body>
</html>
