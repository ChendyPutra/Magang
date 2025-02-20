<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\pengeluaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
{
    // Ambil data dari tabel pemasukan
    $rekapHarian = DB::table('pemasukan')
                    ->select('sumber_dana', 'tanggal', 'jumlah', 'keterangan')
                    ->get();

    // Hitung total pemasukan
    $totalPemasukan = DB::table('pemasukan')->sum('jumlah');

    // Hitung total pengeluaran
    $totalPengeluaran = DB::table('pengeluaran')->sum('jumlah');

    // Data untuk rekap tahunan
    $rekaptahunan = DB::table('pemasukan')
        ->select(
            'pemasukan.tanggal',
            DB::raw('SUM(pemasukan.jumlah) as total_pemasukan'),
            DB::raw('COALESCE(SUM(pengeluaran.jumlah), 0) as total_pengeluaran'),
            DB::raw('(SUM(pemasukan.jumlah) - COALESCE(SUM(pengeluaran.jumlah), 0)) as selisih_dana')
        )
        ->leftJoin('pengeluaran', 'pemasukan.tanggal', '=', 'pengeluaran.tanggal')
        ->groupBy('pemasukan.tanggal')
        ->orderBy('pemasukan.tanggal', 'asc')
        ->get();

    // Kirim semua data ke view
    return view('laporan.index', compact('rekapHarian', 'totalPemasukan', 'totalPengeluaran', 'rekaptahunan'));
}

    public function getData()
    {
       // Ambil data pemasukan dan pengeluaran berdasarkan tanggal yang sama
       $rekaptahunan = DB::table('pemasukan')
       ->select(
           'pemasukan.tanggal',
           DB::raw('SUM(pemasukan.jumlah) as total_pemasukan'),
           DB::raw('COALESCE(SUM(pengeluaran.jumlah), 0) as total_pengeluaran'),
           DB::raw('(SUM(pemasukan.jumlah) - COALESCE(SUM(pengeluaran.jumlah), 0)) as selisih_dana')
       )
       ->leftJoin('pengeluaran', 'pemasukan.tanggal', '=', 'pengeluaran.tanggal')
       ->groupBy('pemasukan.tanggal')
       ->orderBy('pemasukan.tanggal', 'asc')
       ->get();

   // Kirim data ke view
   return view('laporan.index', compact('rekaptahunan'));
    }
    

    public function neracaKeuangan()
    {
    // Ambil data pemasukan dan pengeluaran dari database
    $pemasukan = DB::table('pemasukan')->select('kategori', 'jumlah')->get();
    $pengeluaran = DB::table('pengeluaran')->select('kategori', 'jumlah')->get();

    // Hitung total pemasukan
    $totalPemasukan = $pemasukan->sum('jumlah');

    // Hitung total pengeluaran
    $totalPengeluaran = $pengeluaran->sum('jumlah');

    // Hitung total keseluruhan (pemasukan - pengeluaran)
    $totalKeseluruhan = $totalPemasukan - $totalPengeluaran;

    // Kirim data ke view
    return view('neraca_keuangan', compact('pemasukan', 'pengeluaran', 'totalPemasukan', 'totalPengeluaran', 'totalKeseluruhan'));
    }
    public function downloadPDF()
    {
        $data = [
            "title" => "Neraca Keuangan Tahun 2024",
            "desa" => "Desa Tamantiro",
            "tanggal" => "Per-2024",
            "pemasukan" => [
                ["sumber" => "Dana Desa", "jumlah" => "Rp. 45.000.000,00"],
                ["sumber" => "PADes", "jumlah" => "Rp. 30.000.000,00"],
                ["sumber" => "Sumbangan", "jumlah" => "Rp. 25.000.000,00"],
                ["sumber" => "Hibah", "jumlah" => "Rp. 20.000.000,00"],
            ],
            "pengeluaran" => [
                ["keperluan" => "Kegiatan Sosial", "jumlah" => "Rp. 30.000.000,00"],
                ["keperluan" => "Dana Infrastruktur", "jumlah" => "Rp. 25.000.000,00"],
                ["keperluan" => "Dana Darurat", "jumlah" => "Rp. 10.000.000,00"],
                ["keperluan" => "Belanja Pegawai", "jumlah" => "Rp. 20.000.000,00"],
            ],
            "total_pemasukan" => "Rp. 120.000.000,00",
            "total_pengeluaran" => "Rp. 85.000.000,00",
            "jumlah_total" => "Rp. 205.000.000,00",
        ];

        $pdf = Pdf::loadView('laporan.cetak', $data);
        return $pdf->download('laporan.cetak');
    }
}

