<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Backend</title>

    <!-- Tailwind CDN (v3+) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>

    <script src="https://unpkg.com/heroicons@1.0.6/dist/heroicons.min.js"></script>
    <script>
        // Apply dark mode if previously set
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>


<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Konten utama --}}
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white dark:bg-gray-800 shadow px-6 py-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Backend</h1>
                <button onclick="toggleDark()" class="bg-gray-200 dark:bg-gray-700 p-2 rounded text-sm">
                    Toggle Mode
                </button>
            </header>
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleDark() {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.removeItem('theme');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

</body>

</html>
