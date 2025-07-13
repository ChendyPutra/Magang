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
    // Ambil data rekap harian (semua pemasukan)
    $rekapHarian = DB::table('pemasukan')
        ->select('sumber_dana', 'tanggal', 'jumlah', 'keterangan')
        ->get();

    // Total keseluruhan pemasukan dan pengeluaran
    $totalPemasukan = DB::table('pemasukan')->sum('jumlah');
    $totalPengeluaran = DB::table('pengeluaran')->sum('jumlah');

    // Ambil daftar tahun unik dari pemasukan
    $tahunList = DB::table('pemasukan')
        ->select(DB::raw('YEAR(tanggal) as tahun'))
        ->distinct()
        ->pluck('tahun');

    // Tahun dipilih dari filter atau default tahun sekarang
    $tahunDipilih = request('tahun', now()->year);

    // === REKAP TAHUNAN (Gabungkan pemasukan dan pengeluaran berdasarkan tanggal) ===

    // Subquery pemasukan per tanggal
    $pemasukanSub = DB::table('pemasukan')
        ->select('tanggal', DB::raw('SUM(jumlah) as total_pemasukan'))
        ->whereYear('tanggal', $tahunDipilih)
        ->groupBy('tanggal');

    // Subquery pengeluaran per tanggal
    $pengeluaranSub = DB::table('pengeluaran')
        ->select('tanggal', DB::raw('SUM(jumlah) as total_pengeluaran'))
        ->whereYear('tanggal', $tahunDipilih)
        ->groupBy('tanggal');

    // Gabungkan pemasukan dan pengeluaran berdasarkan tanggal
    $rekaptahunan = DB::table(DB::raw("({$pemasukanSub->toSql()}) as pemasukan"))
        ->mergeBindings($pemasukanSub)
        ->leftJoinSub($pengeluaranSub, 'pengeluaran', 'pemasukan.tanggal', '=', 'pengeluaran.tanggal')
        ->select(
            'pemasukan.tanggal',
            'pemasukan.total_pemasukan',
            DB::raw('COALESCE(pengeluaran.total_pengeluaran, 0) as total_pengeluaran'),
            DB::raw('(pemasukan.total_pemasukan - COALESCE(pengeluaran.total_pengeluaran, 0)) as selisih_dana')
        )
        ->orderBy('pemasukan.tanggal')
        ->get();

    // === NERACA KEUANGAN BERDASARKAN SUMBER DANA DAN KETERANGAN ===

    // Pemasukan berdasarkan sumber dana
    $pemasukanList = DB::table('pemasukan')
        ->select('sumber_dana as sumber', DB::raw('SUM(jumlah) as jumlah'))
        ->whereYear('tanggal', $tahunDipilih)
        ->groupBy('sumber_dana')
        ->get();

    // Pengeluaran berdasarkan keterangan
    $pengeluaranList = DB::table('pengeluaran')
        ->select('keterangan', DB::raw('SUM(jumlah) as jumlah'))
        ->whereYear('tanggal', $tahunDipilih)
        ->groupBy('keterangan')
        ->get();

    // Hitung total dan keseluruhan
    $totalPemasukanNeraca = $pemasukanList->sum('jumlah');
    $totalPengeluaranNeraca = $pengeluaranList->sum('jumlah');
    $totalKeseluruhanNeraca = $totalPemasukanNeraca + $totalPengeluaranNeraca;

    // Kirim ke view
    return view('laporan.index', compact(
        'rekapHarian',
        'totalPemasukan',
        'totalPengeluaran',
        'rekaptahunan',
        'pemasukanList',
        'pengeluaranList',
        'totalPemasukanNeraca',
        'totalPengeluaranNeraca',
        'totalKeseluruhanNeraca',
        'tahunList',
        'tahunDipilih'
    ));
}



    public function getData()
    {
        try {
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

            return response()->json(['data' => $rekaptahunan]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
    public function downloadPDF($tahun = null)
{
    $tahun = $tahun ?? now()->year;

    // Ambil data dari database sesuai tahun
    $pemasukanList = DB::table('pemasukan')
        ->select('sumber_dana as sumber', DB::raw('SUM(jumlah) as jumlah'))
        ->whereYear('tanggal', $tahun)
        ->groupBy('sumber_dana')
        ->get();

    $pengeluaranList = DB::table('pengeluaran')
        ->select('keterangan', DB::raw('SUM(jumlah) as jumlah'))
        ->whereYear('tanggal', $tahun)
        ->groupBy('keterangan')
        ->get();

    $totalPemasukan = $pemasukanList->sum('jumlah');
    $totalPengeluaran = $pengeluaranList->sum('jumlah');
    $jumlahTotal = $totalPemasukan + $totalPengeluaran;

    // Siapkan data untuk cetak
    $data = [
        "title" => "Neraca Keuangan Tahun $tahun",
        "desa" => "Desa Tamantiro",
        "tanggal" => $tahun,
        "pemasukan" => $pemasukanList->map(function ($item) {
            return [
                'sumber' => $item->sumber,
                'jumlah' => $item->jumlah
            ];
        })->toArray(),
        "pengeluaran" => $pengeluaranList->map(function ($item) {
            return [
                'keperluan' => $item->keterangan,
                'jumlah' => $item->jumlah
            ];
        })->toArray(),
        "total_pemasukan" => $totalPemasukan,
        "total_pengeluaran" => $totalPengeluaran,
        "jumlah_total" => $jumlahTotal,
    ];

    // Generate PDF
    $pdf = Pdf::loadView('laporan.cetak', $data);
    return $pdf->download("laporan-keuangan-$tahun.pdf");
}

}

