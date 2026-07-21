<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Floor') · The Pass</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#1F2421',
                        paper: '#FAF7F0',
                        rail: '#E8E1D3',
                        raildark: '#D8CFB8',
                        signal: '#C1440E',
                        go: '#4B7B4E',
                        wait: '#C89B3C',
                    },
                    fontFamily: {
                        display: ['Oswald', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAF7F0; }
        .status-dot { box-shadow: 0 0 0 3px rgba(0,0,0,0.04); }
    </style>
</head>
<body class="font-body text-ink antialiased">
    <div class="min-h-screen flex">
        <aside class="w-56 shrink-0 bg-ink text-paper flex flex-col">
            <div class="px-5 py-6 border-b border-white/10">
                <p class="font-display text-2xl tracking-wide uppercase">The Pass</p>
                <p class="text-xs text-paper/50 mt-0.5">Floor &amp; billing</p>
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                <a href="{{ route('dashboard') }}"
                   class="block px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-white/10 font-semibold' : 'hover:bg-white/5 text-paper/80' }}">
                    Floor
                </a>
                <a href="{{ route('tables.index') }}"
                   class="block px-3 py-2 rounded {{ request()->routeIs('tables.*') ? 'bg-white/10 font-semibold' : 'hover:bg-white/5 text-paper/80' }}">
                    Tables
                </a>
                <a href="{{ route('menu.index') }}"
                   class="block px-3 py-2 rounded {{ request()->routeIs('menu.*') ? 'bg-white/10 font-semibold' : 'hover:bg-white/5 text-paper/80' }}">
                    Menu
                </a>
            </nav>
            <div class="px-5 py-4 border-t border-white/10 text-xs text-paper/40">
                {{ now()->format('D, M j · g:ia') }}
            </div>
        </aside>

        <main class="flex-1 px-8 py-7">
            @if (session('status'))
                <div class="mb-5 px-4 py-2.5 bg-go/10 border border-go/30 text-go text-sm rounded-md font-medium">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
