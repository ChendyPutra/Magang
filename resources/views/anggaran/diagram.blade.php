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
                            <span id="rencanaText" class="font-medium text-green-600">( +{{ number_format($rencana, 2) }}% )</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span class="text-gray-700">Realisasi</span>
                            <span id="realisasiText" class="font-medium text-green-600">( +{{ number_format($realisasi, 2) }}% )</span>
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
                    labels: ['Rencana', 'Realisasi'],
                    datasets: [{
                        data: [0, 0], // Data awal
                        backgroundColor: ['#DE0000', '#0020DF'],
                        borderWidth: 1,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
    
            function updateChart(tahun) {
                fetch(`/filter-statistik/${tahun}`)
                    .then(response => response.json())
                    .then(data => {
                        // Perbarui data chart
                        pieChart.data.datasets[0].data = [data.rencana, data.realisasi];
                        pieChart.update();
    
                        // Perbarui label teks
                        document.getElementById("rencanaText").innerText = `( +${data.rencana}% )`;
                        document.getElementById("realisasiText").innerText = `( +${data.realisasi}% )`;
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
    
            // Dropdown untuk memilih tahun
            const tahunSelect = document.querySelector("#yearSelect");
    
            function handleSelectChange() {
                const tahun = tahunSelect.value;
                updateChart(tahun);
            }
    
            tahunSelect.addEventListener("change", handleSelectChange);
    
            // Inisialisasi dengan tahun default
            const defaultTahun = tahunSelect.value || new Date().getFullYear();
            updateChart(defaultTahun);
        });

    

        // Bar Chart for APBDes (using the same data as Realisasi Anggaran)
        const apbdesCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(apbdesCtx, {
            type: 'bar',
            data: {
                labels: ['Rencana', 'Realisasi'], // Labels are the same as Pie chart (Rencana and Realisasi)
                datasets: [{
                    label: 'Jumlah APBDes',
                    data: [{{ $rencana }}, {{ $realisasi }}], // Use the same values for Bar chart
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

        // Handle year filter change for APBDes chart
        document.getElementById('apbdesYearSelect').addEventListener('change', function() {
            const selectedYear = this.value;
            
            // Log the selected year for debugging purposes
            console.log('Selected Year:', selectedYear);
            
            // Make an AJAX request to get the updated statistics for APBDes chart based on selected year
            fetch(`/filter-apbdes-statistik/${selectedYear}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);  // Check the data coming from the server
                    // Update bar chart data (optional, if dynamic)
                    barChart.data.datasets[0].data = data.apbdesData;
                    barChart.update();
                })
                .catch(error => console.error('Error:', error));
        });

        // Handle year filter change for Realisasi Anggaran (optional, for dynamic data)
        document.getElementById('yearSelect').addEventListener('change', function() {
            const selectedYear = this.value;

            // Log the selected year for debugging purposes
            console.log('Selected Year for Realisasi Anggaran:', selectedYear);
            
            // Make an AJAX request to get the updated statistics for Realisasi Anggaran chart based on selected year
            fetch(`/filter-realisasi-anggaran/${selectedYear}`)
                .then(response => response.json())
                .then(data => {
                    // Update pie chart data (optional, if dynamic)
                    pieChart.data.datasets[0].data = [data.rencana, data.realisasi];
                    pieChart.update();
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</div>
@endsection
