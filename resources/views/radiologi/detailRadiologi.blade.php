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

    .info-box table,
    .info-box th,
    .info-box td {
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
    table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2; /* Highlights header row */
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
                    <h4 id="domba-title">Riwayat usg Domba: {{ $id_domba }}</h4>
                </div>
                <div class="col-2">
                    <a href="/radiologi" class="btn btn-primary">
                        Kembali ke usg
                    </a>
                </div>
                <div class="col-2">
                    <a href="/detail-sheep/{{ $id_domba }}" class="btn btn-primary">
                        Kembali ke domba
                    </a>
                </div>
            </div>
            <br/>
            <div class="col-12">
                    <table>
                        <thead>
                            <tr>
                                <th style="border: 1px solid black; text-align: center;">No</th>
                                <th style="border: 1px solid black; text-align: center;">Tanggal</th>
                                <th style="border: 1px solid black; text-align: center;">Gambar</th>
                                <th style="border: 1px solid black; text-align: center;">Hasil</th>
                            </tr>
                        </thead>
                        <tbody id="riwayat-table-body">
                            <!-- Rows will be inserted here by JavaScript -->
                        </tbody>
                    </table>                
            </div>

            <script>
                window.onload = () => {
                    fetchDombaData();
                };

                function fetchDombaData() {
                    const dombaId = document.getElementById('domba-title').textContent.split(': ')[1];

                    if (dombaId) {
                        fetch(`/domba/dataRadiologi/${dombaId}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log("Data dari API:", data);
                                updateTables(data);
                            })
                            .catch(error => console.error('Error fetching data:', error));
                    }
                }

                function updateTables(data) {
                    const riwayatTableBody = document.getElementById('riwayat-table-body');

                    riwayatTableBody.innerHTML = '';

                    data.forEach((entry, index) => {
                        const rowTemplate = (kondisi) => `
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">${index + 1}</td>
                                <td style="border: 1px solid black; text-align: center;">${new Date(entry.created_at).toLocaleDateString()}</td>
                                <td style="border: 1px solid black; text-align: center;"><img src="${entry.gambar_usg}" alt="USG Image" style="width: 500px;"></td>
                                <td style="border: 1px solid black; text-align: center;">${entry.hasil}</td>
                            </tr>
                        `;

                        riwayatTableBody.innerHTML += rowTemplate(entry.mata);
                    });
                }
            </script>
        </body>
    </section>
</main>
@endsection