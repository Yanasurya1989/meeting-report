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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .btn-keren {
            background: linear-gradient(to right, #4f46e5, #3b82f6);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-keren:hover {
            background: linear-gradient(to right, #4338ca, #2563eb);
            transform: scale(1.05);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>


<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Konten utama --}}
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white dark:bg-gray-800 shadow px-6 py-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Meeting Report</h1>
                {{-- <button onclick="toggleDark()" class="bg-gray-200 dark:bg-gray-700 p-2 rounded text-sm">
                    Toggle Mode
                </button> --}}

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-keren">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>


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
