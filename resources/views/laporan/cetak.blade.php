<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="neraca-keuangan" style="display: none; margin-top: 45px;">
        <h2 class="text-xl font-bold text-center">Neraca Keuangan Tahun 2024</h2>
        <div class="flex items-center justify-end mb-6">
            <div class="flex space-x-2" style="margin-right: 10px">
                <button id="download-pdf" class="px-4 py-2 text-white bg-gray-800 rounded-md hover:bg-purple-600">
                    <i class="mr-2 fas fa-download"></i>
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
</body>
</html>