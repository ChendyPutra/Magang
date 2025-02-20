<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<nav class="fixed z-10 flex items-center justify-between w-full bg-purple-900 shadow-lg md:p-4">
    <div class="text-lg font-semibold text-navy">
        <img src="/images/logo.png" alt="Logo" class="w-10 h-10 mr-2">
    </div>
    <h1 class="font-bold text-white">PEMASUKAN/PENGELUARAN</h1>
    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="text-gray-100 hover:text-gray-100 dark:text-gray-100 dark:hover:text-gray-300">
            {{ __('Log Out') }}
        </button>
    </form>
    <button id="menu-button" class="md:hidden text-navy">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</nav>


<div style="display: flex; padding-top: 4rem;">
    <!-- Sidebar -->
    <aside style="width: 16rem; background-color: #E6ECFF; color: white; flex-shrink: 0; height: calc(100vh - 4rem); padding: 1rem;">
        <ul style="margin-top: 1rem; list-style: none; padding: 0;">
            <li style="margin-bottom: 1rem;">
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-2 rounded transition duration-200 {{ request()->is('dashboard') ? 'bg-purple-700 text-white' : 'hover:bg-purple-300 text-black' }}">
                    Pemasukan/Pengeluaran
                </a>
            </li>
            <li style="margin-bottom: 1rem;">
                <a href="{{ route('pengelolaan.index') }}"
                    class="block px-4 py-2 rounded transition duration-200 {{ request()->is('pengelolaan*') ? 'bg-purple-700 text-white' : 'hover:bg-purple-300 text-black' }}">
                    Pengelolaan Anggaran
                </a>
            </li>
            <li style="margin-bottom: 1rem;">
                <a href="{{ route('laporan.index') }}"
                    class="block px-4 py-2 rounded transition duration-200 {{ request()->is('laporan*') ? 'bg-purple-700 text-white' : 'hover:bg-purple-300 text-black' }}">
                    Laporan Keuangan
                </a>
            </li>
            <li style="margin-bottom: 1rem;">
                <a href="{{ route('komentar.index') }}"
                    class="block px-4 py-2 rounded transition duration-200 {{ request()->is('komentar*') ? 'bg-purple-700 text-white' : 'hover:bg-purple-300 text-black' }}">
                    Komentar Publik
                </a>
            </li>
        </ul>
    </aside>
