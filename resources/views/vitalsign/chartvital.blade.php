@extends('layouts.template')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
    .info-box {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 200px;
        text-align: center;
    }

    .info-box h5 {
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .info-box table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-box table, .info-box th, .info-box td {
        border: 1px solid #ddd;
        padding: 4px;
        font-size: 12px;
    }

    .info-box th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .d-flex {
        display: flex;
        gap: 20px;
        justify-content: center;
        align-items: center;
    }
</style>

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
    </div>
    <section class="section">
        <body>
            <div class="d-flex">
                <div class="col-8">
                    <h4 id="domba-title">Chart Vital Sign Domba: {{ $id_domba }}</h4>
                </div>
                <div class="col-2">
                    <a href="/vital-sign" class="btn btn-primary">
                        Kembali ke vital
                    </a>
                </div>
                <div class="col-2">
                    <a href="/detail-sheep/{{ $id_domba }}" class="btn btn-primary">
                        Kembali ke domba
                    </a>
                </div>
            </div>

            <div>
                <canvas id="combinedChart" width="800" height="400"></canvas>
            </div>

            <div class="d-flex justify-content-around mt-4">
                <div class="info-box">
                    <h5>Mata</h5>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody id="mata-table-body">
                            <!-- Rows will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="info-box">
                    <h5>Kuku</h5>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody id="kuku-table-body">
                            <!-- Rows will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="info-box">
                    <h5>Kondisi</h5>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody id="kondisi-table-body">
                            <!-- Rows will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                let combinedChart;

                window.onload = () => {
                    fetchDombaData();
                };

                function fetchDombaData() {
                    const dombaId = document.getElementById('domba-title').textContent.split(': ')[1];

                    if (dombaId) {
                        fetch(`/domba/data/${dombaId}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log("Data dari API:", data);
                                updateCombinedChart(data);
                                updateTables(data);
                            })
                            .catch(error => console.error('Error fetching data:', error));
                    }
                }

                function updateCombinedChart(data) {
                    const labels = data.map(entry => new Date(entry.created_at).toLocaleDateString());

                    const detakJantungData = data.map(entry => entry.detak_jantung);
                    const beratData = data.map(entry => entry.berat);
                    const suhuData = data.map(entry => entry.suhu);
                    const pernafasanData = data.map(entry => entry.pernafasan);

                    const tekananDarahSistolik = [];
                    const tekananDarahDiastolik = [];
                    data.forEach(entry => {
                        if (entry.tekanan_darah && entry.tekanan_darah.includes('/')) {
                            const [sistolik, diastolik] = entry.tekanan_darah.split('/').map(Number);
                            tekananDarahSistolik.push(sistolik);
                            tekananDarahDiastolik.push(diastolik);
                        } else {
                            tekananDarahSistolik.push(null);
                            tekananDarahDiastolik.push(null);
                        }
                    });

                    if (combinedChart) combinedChart.destroy();

                    const ctx = document.getElementById('combinedChart').getContext('2d');
                    combinedChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Detak Jantung',
                                    data: detakJantungData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: false,
                                    tension: 0.1
                                },
                                {
                                    label: 'Tekanan Darah Sistolik',
                                    data: tekananDarahSistolik,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: false,
                                    tension: 0.1
                                },
                                {
                                    label: 'Tekanan Darah Diastolik',
                                    data: tekananDarahDiastolik,
                                    borderColor: 'rgba(255, 159, 64, 1)',
                                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                    fill: false,
                                    tension: 0.1
                                },
                                {
                                    label: 'Berat',
                                    data: beratData,
                                    borderColor: 'rgba(255, 206, 86, 1)',
                                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                    fill: false,
                                    tension: 0.1
                                },
                                {
                                    label: 'Suhu',
                                    data: suhuData,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: false,
                                    tension: 0.1
                                },
                                {
                                    label: 'Pernafasan',
                                    data: pernafasanData,
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    fill: false,
                                    tension: 0.1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Chart Vital Sign Gabungan'
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false
                                },
                                hover: {
                                    mode: 'nearest',
                                    intersect: true
                                }
                            }
                        }
                    });
                }

                function updateTables(data) {
                    const mataTableBody = document.getElementById('mata-table-body');
                    const kukuTableBody = document.getElementById('kuku-table-body');
                    const kondisiTableBody = document.getElementById('kondisi-table-body');
                    
                    mataTableBody.innerHTML = '';
                    kukuTableBody.innerHTML = '';
                    kondisiTableBody.innerHTML = '';

                    data.forEach((entry, index) => {
                        const rowTemplate = (kondisi) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${new Date(entry.created_at).toLocaleDateString()}</td>
                                <td>${kondisi}</td>
                            </tr>
                        `;

                        mataTableBody.innerHTML += rowTemplate(entry.mata);
                        kukuTableBody.innerHTML += rowTemplate(entry.kuku);
                        kondisiTableBody.innerHTML += rowTemplate(entry.kondisi);
                    });
                }
            </script>
        </body>
    </section>
</main>
@endsection
