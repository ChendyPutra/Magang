@extends('pengelolaan.index')

@section('content')
    <div id="rapbdes-content" class="content-section">
        <!-- Header -->
        <div class="flex justify-between space-x-6" style="margin-top: 5%">
            <!-- Card Realisasi Anggaran -->
            <div class="w-1/2 p-6 bg-white rounded-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">Statistik Realisasi Anggaran</h3>
                    <div class="flex space-x-2">
                        <select class="px-3 py-2 text-sm border border-gray-300 rounded" id="yearSelect">
                            @foreach($tahun as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-start md:flex-row">
                    <div class="flex-shrink-0 w-full mb-6 md:w-auto md:mb-0 md:mr-8">
                        <canvas id="pieChart" class="w-64 h-64"></canvas>
                    </div>

                    <div class="w-full md:w-auto">
                       <ul class="space-y-4">
    <li class="flex items-center justify-between">
        <span class="text-gray-700">Rencana</span>
        <span id="rencanaText" class="font-medium text-blue-700">-</span>
    </li>
    <li class="flex items-center justify-between">
        <span class="text-gray-700">Realisasi</span>
        <span id="realisasiText" class="font-medium text-green-600">-</span>
    </li>
</ul>


                    </div>
                </div>
            </div>


            <!-- Card APBDes -->
            <div class="w-1/2 p-6 bg-white rounded-lg">
                <!-- Statistik Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">Statistik APBDes</h3>
                    <div class="flex space-x-2">
                        <select class="px-3 py-2 text-sm border border-gray-300 rounded" id="apbdesYearSelect">
                            @foreach($tahun as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Chart dan Data -->
                <div class="flex flex-col items-center justify-start md:flex-row" style="margin-top: 20%; margin-left: 20%">
                    <!-- Bar Chart -->
                    <div class="flex-shrink-0 w-full mb-6 md:w-auto md:mb-0 md:mr-8">
                        <canvas id="barChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>

      <!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
     document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('pieChart').getContext('2d');

        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Realisasi', 'Belum Terealisasi'],
                datasets: [{
                    data: [0, 0],
                    backgroundColor: ['#0020DF', '#DE0000'],
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
                            usePointStyle: true,
                            generateLabels: function (chart) {
                                const data = chart.data.datasets[0].data;
                                const total = data.reduce((a, b) => a + b, 0);
                                return chart.data.labels.map((label, i) => {
                                    const value = data[i];
                                    const percent = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                                    return {
                                        text: `${label} - ${percent}%`,
                                        fillStyle: chart.data.datasets[0].backgroundColor[i],
                                        strokeStyle: '#fff',
                                        index: i
                                    };
                                });
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const data = context.chart.data.datasets[0].data;
                                const total = data.reduce((a, b) => a + b, 0);
                                const value = context.parsed;
                                const percent = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                                return `${context.label}: ${percent}%`;
                            }
                        }
                    }
                }
            }
        });

       function updateChart(tahun) {
    fetch(`/filter-statistik/${tahun}`)
        .then(response => response.json())
        .then(data => {
            const rencana = parseFloat(data.rencana);
            const realisasi = parseFloat(data.realisasi);

            const total = rencana > 0 ? rencana : 1;
            const persenRealisasi = ((realisasi / total) * 100).toFixed(2);
            const persenSisa = (100 - persenRealisasi).toFixed(2);

            // Update pie chart data (dalam persen)
            pieChart.data.datasets[0].data = [persenRealisasi, persenSisa];
            pieChart.update();

            // Tampilkan label dalam persen
            document.getElementById("rencanaText").innerText = `( ${persenSisa}% )`;
            document.getElementById("realisasiText").innerText = `( ${persenRealisasi}% )`;
        })
        .catch(error => console.error('Error fetching data:', error));
}

        const tahunSelect = document.querySelector("#yearSelect");
        tahunSelect.addEventListener("change", () => updateChart(tahunSelect.value));
        updateChart(tahunSelect.value || new Date().getFullYear());
    });

    // Bar Chart for APBDes (tidak diubah)
    const apbdesCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(apbdesCtx, {
        type: 'bar',
        data: {
            labels: ['Rencana', 'Realisasi'],
            datasets: [{
                label: 'Jumlah APBDes',
                data: [{{ $rencana }}, {{ $realisasi }}],
                backgroundColor: '#3b82f6',
                borderColor: '#2563eb',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    document.getElementById('apbdesYearSelect').addEventListener('change', function () {
        const selectedYear = this.value;
        fetch(`/filter-apbdes-statistik/${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                barChart.data.datasets[0].data = data.apbdesData;
                barChart.update();
            })
            .catch(error => console.error('Error:', error));
    });
</script>

    </div>
@endsection