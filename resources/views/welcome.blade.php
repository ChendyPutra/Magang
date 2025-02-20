<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sumberarum Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .footer {
        background-color: #313131;
        color: #fff;
        padding: 2rem 0;
    }

    .footer-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .footer-section {
        flex: 1;
        margin: 0 1rem;
    }

    .footer-title {
        padding-left: 0.5rem;
        border-left: 3px solid #00acc1;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 0.5rem;
    }

    .footer-section ul li a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-section ul li a:hover {
        color: #00acc1;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 2rem;
        font-size: 0.9rem;
    }
    </style>
</head>

<body class="bg-white " >
    <nav class="fixed z-10 flex items-center justify-between w-full shadow-lg md:p-4" style="background-color: #313131;">
        <div class="flex items-center">
            <a href="#" class="text-lg font-semibold text-navy">
                <img src="images/logo.png" alt="Your Logo" class="w-10 h-10 mr-2">
            </a>
            <a href="#" class="text-left text-white">Sumberarum</a>
        </div>
        <div class="flex items-center ml-80 space-x-9 md:space-x-10">
            <a href="#pemasukan" class="ml-20 text-xs " style="color: white;">PEMASUKAN</a>
            <a href="{{ route('pengeluaran_view') }}" class="ml-20 text-xs {{ Route::currentRouteName() == 'pengeluaran' ? 'border-b-2 border-white' : '' }}" style="color: white;">PENGELUARAN</a>
            <a href="{{ route('RAPBDes') }}" class="ml-20 text-xs {{ Route::currentRouteName() == 'RAPBDes' ? 'border-b-2 border-white' : '' }}" style="color: white;">RAPBDES</a>
        </div>
        <div class="flex items-center space-x-6 md:space-x-10">
            <a href="" class="text-navy hover:text-sky-50" style="color: white;"></a>
        </div>
        <button id="menu-button" class="md:hidden text-navy">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </nav>

    <section class="w-full h-screen bg-white bg-center bg-cover" style="background-image: url('images/pattern.png');">
        <div class="container flex flex-col justify-center h-full px-4 pt-10 pb-10 pl-4 pr-4 mx-auto bg-black items-left text-start bg-opacity-30">
            <div class="w-full md:w-1/2">
                <h1 class="mb-6 text-5xl font-extrabold text-white text-navy">
                    Selamat datang di Sistem Pengelolaan Keuangan Desa Sumberarum
                </h1>
            </div>
        </div>
    </section>

    <section class="w-full h-screen bg-center bg-cover" id="pemasukan" style="background-image: url('images/pemasukan.png')">
        <div class="flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <div class="text-center">
                <h2 class="mb-16 text-4xl font-semibold text-white">Pemasukan Desa Sumberarum</h2>
                <a href="#statistik" class="px-6 py-3 font-extrabold text-black bg-white rounded-lg hover:bg-gray-800">
                    Lanjut
                </a>
            </div>
        </div>
    </section>

    <section id="statistik" class="container py-16 mx-auto">
        <!-- Header -->
        <h2 class="mb-8 ml-20 text-2xl font-bold text-left text-black">Data Pemasukan</h2>
        <!-- Card Container -->
        <div class="p-6 bg-white rounded-lg ">
            <!-- Statistik Header -->
            <div class="flex items-center justify-around mb-6">
                <h3 class="text-lg font-semibold">Statistik</h3>
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

            <div class="flex flex-col items-center justify-center md:flex-row">
                <!-- Pie Chart -->
                <div class="flex-shrink-0 w-full mb-6 md:w-auto md:mb-0 md:mr-8">
                    <canvas id="pieChart" class="w-64 h-64"></canvas>
                </div>
            
                <!-- Data List -->
                <div class="w-full md:w-auto">
                    <ul id="categoryList" class="space-y-4"></ul>
                </div>
            </div>
            
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Data Laravel
                    const pemasukanData = @json($pemasukan);
            
                    // Kategori tetap
                    const categories = ['APBN', 'APBD', 'Dana Desa', 'Swadaya'];
            
                    // Total pemasukan
                    const totalPemasukan = pemasukanData.reduce((sum, item) => sum + parseFloat(item.jumlah), 0);
            
                    // Hitung jumlah setiap kategori
                    const dataValues = categories.map(category => {
                        const categoryTotal = pemasukanData
                            .filter(item => item.sumber_dana === category)
                            .reduce((sum, item) => sum + parseFloat(item.jumlah), 0);
                        return categoryTotal;
                    });
            
                    // Warna kategori
                    const colors = ['#001175', '#001ED6', '#0125FF', '#4862FF'];
            
                    // Inisialisasi Pie Chart
                    const ctx = document.getElementById('pieChart').getContext('2d');
                    const pieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: categories,
                            datasets: [{
                                data: dataValues,
                                backgroundColor: colors,
                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        font: {
                                            size: 14
                                        }
                                    }
                                }
                            }
                        }
                    });
            
                    // Update daftar kategori dengan persentase
                    const categoryList = document.getElementById('categoryList');
                    categories.forEach((category, index) => {
                        const percentage = totalPemasukan > 0
                            ? ((dataValues[index] / totalPemasukan) * 100).toFixed(2)
                            : 0;
                        const listItem = document.createElement('li');
                        listItem.className = 'flex items-center justify-between';
                        listItem.innerHTML = `
                            <span class="text-gray-700">${category}</span>
                            <span class="font-medium text-green-600">${percentage}%</span>
                        `;
                        categoryList.appendChild(listItem);
                    });
                });
            </script>
            
                        
    </section>

    <section class="container items-center justify-center w-full py-16 mx-auto bg-white bg-center bg-cover">
        <div class="max-w-5xl mx-auto overflow-hidden rounded-lg shadow-lg">
            <table class="w-full border border-gray-400 table-auto">
                <thead>
                    <tr class="bg-blue-700 text-white">
                        <th class="px-4 py-2 text-center border">No</th>
                        <th class="px-4 py-2 text-center border">Sumber Dana</th>
                        <th class="px-4 py-2 text-center border">Jumlah</th>
                        <th class="px-4 py-2 text-center border">Tanggal</th>
                        <th class="px-4 py-2 text-center border">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemasukan as $index => $item)
                    <tr class="text-center">
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $item->sumber_dana }}</td>
                        <td class="px-4 py-2 border">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 border">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="py-8 bg-gray-100">
        <div class="container mx-auto">
          <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-2xl font-bold">Komentar</h2>
            <div class="space-y-4">
                <form action="{{ route('komentar.store', ['type' => 'pemasukan']) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <input 
                            type="text" 
                            name="nama" 
                            placeholder="Masukkan Nama" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <textarea 
                            name="komentar" 
                            placeholder="Tambahkan Komentar" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md"></textarea>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="anonymous" name="anonymous" class="mr-2">
                        <label for="anonymous" class="text-gray-600">Komentar sebagai Anonymous</label>
                    </div>
                    <button type="submit" class="px-4 py-2 font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                        Kirim
                    </button>
                </form>
                
            </div>
          </div>
        </div>
      </section>
      
    

    <footer class="footer">
        <div class=" footer-container">

            <div class="footer-section">
                <h4 class="footer-title" >Tentang</h4>
                <p>Sumberarum adalah sebuah desa yang terletak di Kecamatan Moyudan, Sleman, Daerah Istimewa Yogyakarta, Indonesia. Desa Sumberarum pada awalnya terbagi menjadi 4 bekas Kelurahan lama, yaitu Kelurahan Sejatisapar, Puluhan, Sremo, dan Jitardukuh.</p>
            </div>

            <div class="footer-section">
                <h4 class="footer-title" >Navigasi</h4>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#pemasukan">Pemasukan</a></li>
                    <li><a href="{{ route('pengeluaran_view') }}" >Pengeluaran</a></li>
                    <li><a href="{{ route('RAPBDes') }}" >RAPBDes</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4 class="footer-title" >Alamat</h4>
                <p>Sumberarum<br>Moyudan, Sleman Regency,<br>Special Region of Yogyakarta</p>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Tim PRC. All rights reserved.</p>
        </div>

    </footer>

</body>

</html>




