<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sumberarum Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>

    </style>
</head>

<body class="bg-white " >
    <nav class="fixed z-10 flex items-center justify-between w-full bg-purple-900 shadow-lg md:p-4">
        <div class="text-lg font-semibold text-navy">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 mr-2">
        </div>
        <h1 class="font-bold text-white">PENGELOALAAN ANGGARAN</h1>
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


        <!-- Content Area -->
        <main style="flex: 1; padding: 1.5rem; background-color: #f3f4f6;">
            <div class="flex items-center space-x-6 md:space-x-10">
                <a href="#" id="hari-btn" class="text-lg font-semibold text-navy hover:bg-gray-500 hover:text-white px-4 py-2 rounded transition duration-200">Rekap Per-Hari</a>
                <a href="#" id="tahunan-btn" class="text-lg font-semibold text-navy hover:bg-gray-500 hover:text-white px-4 py-2 rounded transition duration-200">Rekap Bulanan-Tahunan</a>
                <a href="#" id="keuangan-btn" class="text-lg font-semibold text-navy hover:bg-gray-500 hover:text-white px-4 py-2 rounded transition duration-200">Neraca Keuangan</a>
            </div>

            <div id="rekap-hari" style="margin-top: 45px; display: none;">
                <h2 class="text-xl font-bold text-center">Januari 2024</h2>
                <div class="flex items-center justify-end mb-6">
                    <div class="flex space-x-2">
                        <select class="px-3 py-2 text-sm border border-gray-300 rounded">
                            <option>Jan</option>
                            <option>Feb</option>
                            <option>Mar</option>
                            <!-- Tambahkan bulan lainnya -->
                        </select>
                        <select class="px-3 py-2 text-sm border border-gray-300 rounded">
                            <option>2021</option>
                            <option>2022</option>
                            <option>2023</option>
                        </select>
                    </div>
                </div>
                <table class="w-full mt-6 bg-white shadow-lg rounded-lg">
                    <thead>
                        <tr style="background-color: #54BDFF; color: white;">
                            <th class="border-r" style="padding: 0.5rem;">No</th>
                            <th class="border-r" style="padding: 0.5rem;">Kategori</th>
                            <th class="border-r" style="padding: 0.5rem;">Kategori Dana</th>
                            <th class="border-r" style="padding: 0.5rem;">Tanggal</th>
                            <th class="border-r" style="padding: 0.5rem;">Jumlah</th>
                            <th class="border-r" style="padding: 0.5rem;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($rekapHarian as $item)
                            <tr class="border-t">
                                <td class="p-2">{{ $no++ }}</td>
                                <td class="p-2">{{ $item->sumber_dana }}</td>
                                <td class="p-2">{{ $item->sumber_dana }}</td>
                                <td class="p-2">{{ $item->tanggal }}</td>
                                <td class="p-2">{{ $item->jumlah }}</td>
                                <td class="p-2">{{ $item->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="rekap-tahunan" style="margin-top: 45px"> 
                <h2 class="text-xl font-bold text-center">Rekap Tahun 2024</h2>
                <table style="width: 100%; margin-top: 1.5rem; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 0.375rem;">
                    <thead>
                        <tr style="background-color: #54BDFF; color: white;">
                            <th class="border-r" style="padding: 0.5rem;">No</th>
                            <th class="border-r" style="padding: 0.5rem;">Tanggal</th>
                            <th class="border-r" style="padding: 0.5rem;">Pemasukan</th>
                            <th class="border-r" style="padding: 0.5rem;">Pengeluaran</th>
                            <th class="border-r" style="padding: 0.5rem;">Selisih Dana</th>
                        </tr>
                    </thead>
                    <tbody id="rekapTableBody">
                        @foreach($rekaptahunan as $index => $item)
                            <tr class="border-t">
                                <td class="p-2">{{ $index + 1 }}</td>
                                <td class="p-2">{{ $item->tanggal }}</td>
                                <td class="p-2">{{ number_format($item->total_pemasukan, 0, ',', '.') }}</td>
                                <td class="p-2">{{ number_format($item->total_pengeluaran, 0, ',', '.') }}</td>
                                <td class="p-2">{{ number_format($item->selisih_dana, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            

            <div id="neraca-keuangan" style="display: none; margin-top: 45px;">
                <h2 class="text-xl font-bold text-center">Neraca Keuangan Tahun 2024</h2>
                <div class="flex items-center justify-end mb-6">
                    <div class="flex space-x-2" style="margin-right: 10px">
                        <button id="download-pdf" class="px-4 py-2 text-white bg-gray-800 rounded-md hover:bg-purple-600">
                            <i class="mr-2 fas fa-download"></i> Download PDF
                        </button>
                        
                    </div>
                    <select class="px-3 py-2 text-sm border border-gray-300 rounded">
                        <option>2022</option>
                        <option>2023</option>
                        <option selected>2024</option>
                    </select>
                </div>
                
                <div class="overflow-hidden bg-white rounded-lg shadow-md">
                    <div class="px-6 py-5 font-bold text-center text-white bg-gray-800">
                        Desa Tamantiro<br>
                        Laporan Posisi Keuangan<br>
                        Per-2024 (Dalam Rp)
                    </div>
                    <div class="p-6">
                        <div class="font-bold mb-2">Keterangan</div>
                        <!-- APBD -->
                        <div class="mb-4">
                            <div class="font-bold">APBD</div>
                            <div class="flex justify-between">
                                <div>Pemasukan</div>
                                <div>Rp. 120.000.000,00</div>
                            </div>
                            <div class="flex justify-between">
                                <div>Pengeluaran</div>
                                <div>Rp. 85.000.000,00</div>
                            </div>
                            <div class="flex justify-between font-bold">
                                <div>JUMLAH APBD</div>
                                <div>Rp. 205.000.000,00</div>
                            </div>
                        </div>
                        <!-- PEMASUKAN -->
                        <div class="mb-4">
                            <div class="font-bold">PEMASUKAN</div>
                            <div class="flex justify-between"><div> Dana Desa</div><div>Rp. 45.000.000,00</div></div>
                            <div class="flex justify-between"><div> PADes</div><div>Rp. 30.000.000,00</div></div>
                            <div class="flex justify-between"><div> Sumbangan</div><div>Rp. 25.000.000,00</div></div>
                            <div class="flex justify-between"><div> Hibah</div><div>Rp. 20.000.000,00</div></div>
                            <div class="flex justify-between font-bold">
                                <div>JUMLAH PEMASUKAN</div>
                                <div>Rp. 120.000.000,00</div>
                            </div>
                        </div>
                        <!-- PENGELUARAN -->
                        <div class="mb-4">
                            <div class="font-bold">PENGELUARAN</div>
                            <div class="flex justify-between"><div> Kegiatan Sosial</div><div>Rp. 30.000.000,00</div></div>
                            <div class="flex justify-between"><div> Dana Infrastruktur</div><div>Rp. 25.000.000,00</div></div>
                            <div class="flex justify-between"><div> Dana Darurat</div><div>Rp. 10.000.000,00</div></div>
                            <div class="flex justify-between"><div> Belanja Pegawai</div><div>Rp. 20.000.000,00</div></div>
                            <div class="flex justify-between font-bold">
                                <div>JUMLAH PENGELUARAN</div>
                                <div>Rp. 85.000.000,00</div>
                            </div>
                        </div>
                        <!-- TOTAL -->
                        <div class="font-bold border-t pt-2">
                            <div class="flex justify-between">
                                <div>JUMLAH PEMASUKAN DAN PENGELUARAN</div>
                                <div>Rp. 205.000.000,00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <script>
                const rekapHari = document.getElementById('rekap-hari');
                const rekapTahunan = document.getElementById('rekap-tahunan');
                const neracaKeuangan = document.getElementById('neraca-keuangan');

                const hariBtn = document.getElementById('hari-btn');
                const tahunanBtn = document.getElementById('tahunan-btn');
                const keuanganBtn = document.getElementById('keuangan-btn');

                hariBtn.addEventListener('click', () => {
                    rekapHari.style.display = 'block';
                    rekapTahunan.style.display = 'none';
                    neracaKeuangan.style.display = 'none';
                });

                tahunanBtn.addEventListener('click', () => {
                    rekapHari.style.display = 'none';
                    rekapTahunan.style.display = 'block';
                    neracaKeuangan.style.display = 'none';
                });

                keuanganBtn.addEventListener('click', () => {
                    rekapHari.style.display = 'none';
                    rekapTahunan.style.display = 'none';
                    neracaKeuangan.style.display = 'block';
                });
                document.getElementById('hari-btn').addEventListener('click', function() {
                    // Menambahkan underline pada Rekap Per-Hari dan menghapusnya dari yang lain
                    document.getElementById('hari-btn').classList.add('underline');
                    document.getElementById('tahunan-btn').classList.remove('underline');
                    document.getElementById('keuangan-btn').classList.remove('underline');
                });

                document.getElementById('tahunan-btn').addEventListener('click', function() {
                    // Menambahkan underline pada Rekap Bulanan-Tahunan dan menghapusnya dari yang lain
                    document.getElementById('tahunan-btn').classList.add('underline');
                    document.getElementById('hari-btn').classList.remove('underline');
                    document.getElementById('keuangan-btn').classList.remove('underline');
                });

                document.getElementById('keuangan-btn').addEventListener('click', function() {
                    // Menambahkan underline pada Neraca Keuangan dan menghapusnya dari yang lain
                    document.getElementById('keuangan-btn').classList.add('underline');
                    document.getElementById('hari-btn').classList.remove('underline');
                    document.getElementById('tahunan-btn').classList.remove('underline');
                });
                document.getElementById('download-pdf').addEventListener('click', function () {
                        window.location.href = "{{ route('download.pdf') }}";
                    });

                    $(document).ready(function () {
        function fetchRekap() {
            $.get("{{ route('rekap.data') }}", function (data) {
                console.log(data); // Debugging - Pastikan data JSON muncul
                let tbody = "";
                let no = 1;
                data.forEach(row => {
                    let pemasukan = parseFloat(row.pemasukan); // Konversi ke number
                    let pengeluaran = parseFloat(row.pengeluaran); // Konversi ke number
                    let selisih = pemasukan - pengeluaran;

                    tbody += `<tr style='border-top: 1px solid #e5e7eb;'>
                        <td class='text-center border-r'>${no++}</td>
                        <td class='text-center border-r'>${row.tanggal}</td>
                        <td class='text-center border-r'>${pemasukan.toLocaleString()}</td>
                        <td class='text-center border-r'>${pengeluaran.toLocaleString()}</td>
                        <td class='text-center border-r'>${selisih.toLocaleString()}</td>
                    </tr>`;
                });
                $("#rekapTableBody").html(tbody);
            }).fail(function () {
                alert("Gagal mengambil data. Cek console untuk detail error.");
            });
        }
        fetchRekap();
    });
            </script>

        </main>
    </div>

</body>

</html>
