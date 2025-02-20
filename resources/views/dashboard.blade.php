<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sumberarum Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>

    </style>
</head>

<body class="bg-white " >
    @include('layouts.navigation')

        <!-- Content Area -->
        <main style="flex: 1; padding: 1.5rem; background-color: #f3f4f6;">
            <div class="flex items-center space-x-6 md:space-x-10">
                <a href="{{ route('pemasukan.index') }}" id="pemasukan-btn" class="text-lg font-semibold text-navy hover:bg-gray-500 hover:text-white px-4 py-2 rounded transition duration-200">
                    Transaksi Pemasukan
                </a>
                <a href="{{ route('pengeluaran.index') }}" id="pengeluaran-btn" class="text-lg font-semibold text-navy hover:bg-gray-500 hover:text-white px-4 py-2 rounded transition duration-200">
                    Transaksi Pengeluaran
                </a>
            </div>


            @yield(section: 'content')

            @yield('scripts')

        </main>

    </div>

</body>

</html>
