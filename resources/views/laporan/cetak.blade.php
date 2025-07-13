<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .box { border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-top: 20px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">{{ $title }}</h2>
    <p><strong>Desa:</strong> {{ $desa }}</p>
    <p><strong>Per:</strong> {{ $tanggal }}</p>

    <div class="box">
        <div class="bold">APBD</div>
        <div class="row"><div>Pemasukan</div><div>{{ $total_pemasukan }}</div></div>
        <div class="row"><div>Pengeluaran</div><div>{{ $total_pengeluaran }}</div></div>
        <div class="row bold"><div>JUMLAH APBD</div><div>{{ $jumlah_total }}</div></div>
    </div>

    <div class="box">
        <div class="bold">PEMASUKAN</div>
        @foreach($pemasukan as $item)
            <div class="row"><div>{{ $item['sumber'] }}</div><div>{{ $item['jumlah'] }}</div></div>
        @endforeach
        <div class="row bold"><div>JUMLAH PEMASUKAN</div><div>{{ $total_pemasukan }}</div></div>
    </div>

    <div class="box">
        <div class="bold">PENGELUARAN</div>
        @foreach($pengeluaran as $item)
            <div class="row"><div>{{ $item['keperluan'] }}</div><div>{{ $item['jumlah'] }}</div></div>
        @endforeach
        <div class="row bold"><div>JUMLAH PENGELUARAN</div><div>{{ $total_pengeluaran }}</div></div>
    </div>

    <div class="box bold">
        <div class="row"><div>JUMLAH PEMASUKAN DAN PENGELUARAN</div><div>{{ $jumlah_total }}</div></div>
    </div>
</body>
</html>
