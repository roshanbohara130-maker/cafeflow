<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-amber-50 via-orange-50 to-stone-100 px-4 py-10">
        <div class="w-full max-w-md">

            {{-- Logo / brand --}}
            <div class="flex flex-col items-center mb-6">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-amber-800 shadow-lg mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9h13.5a3.75 3.75 0 010 7.5h-.75m-12.75-7.5v7.5A2.25 2.25 0 006 18.75h6.75A2.25 2.25 0 0015 16.5V9m-12 0V6.75A1.5 1.5 0 014.5 5.25h9A1.5 1.5 0 0115 6.75V9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M11.25 3v1.5" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-stone-800 tracking-tight">Cafe<span class="text-amber-700">Flow</span></h1>
                <p class="text-sm text-stone-500 mt-1">Welcome back, let's get brewing</p>
            </div>

            {{-- Card --}}
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-amber-100 px-8 py-8">

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="text-stone-700 font-medium" />
                        <x-input
                            id="email"
                            class="block mt-1 w-full rounded-lg border-stone-300 bg-stone-50 focus:border-amber-600 focus:ring-amber-600 focus:bg-white transition"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="you@cafeflow.com"
                        />
                    </div>

                    <div>
                        <x-label for="password" value="{{ __('Password') }}" class="text-stone-700 font-medium" />
                        <x-input
                            id="password"
                            class="block mt-1 w-full rounded-lg border-stone-300 bg-stone-50 focus:border-amber-600 focus:ring-amber-600 focus:bg-white transition"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center select-none">
                            <x-checkbox id="remember_me" name="remember" class="rounded border-stone-300 text-amber-700 focus:ring-amber-600" />
                            <span class="ms-2 text-sm text-stone-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-amber-700 hover:text-amber-900 underline-offset-2 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full flex justify-center items-center gap-2 rounded-lg bg-amber-800 hover:bg-amber-900 active:bg-amber-950 text-white font-semibold py-2.5 shadow-md transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-700">
                        {{ __('Log in') }}
                    </button>
                </form>
            </div>

            <p class="text-center text-xs text-stone-400 mt-6">
                &copy; {{ date('Y') }} CafeFlow. All rights reserved.
            </p>
        </div>
    </div>
</x-guest-layout>
