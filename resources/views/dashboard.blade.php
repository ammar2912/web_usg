@extends('layouts.template')

@section('content')

<head>
    <!-- Existing head content -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Bootstrap CSS (jika belum ada di template) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Samakan ukuran img carousel dengan video */
        .carousel-item img {
            width: 100%;
            aspect-ratio: 16 / 9;
            /* otomatis jaga rasio */
            object-fit: cover;
            /* biar gambar tidak gepeng */
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .stat-card h4 {
            font-size: 12px;
            text-transform: uppercase;
            margin: 0;
            font-weight: bold;
            color: #666;
        }

        .stat-card p {
            font-size: 22px;
            margin: 5px 0 0;
            font-weight: bold;
            color: #333;
        }

        .icon {
            font-size: 28px;
            opacity: 0.3;
        }
    </style>
</head>

<main id="main" class="main">
    <div class="row">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center p-2">
                <div>Dashboard</div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center">News</h4>
                <div class="row mt-4">

                    <div class="col-md-6">
                        <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('images/domba.jpg') }}" class="d-block w-100" alt="Slide 1">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Data domba</h5>
                                        <p>Pengambilan data domba</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/pengambilan_usg.jpg') }}" class="d-block w-100" alt="Slide 2">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>USG</h5>
                                        <p>Pengambilan USG</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/contoh_usg.jpg') }}" class="d-block w-100" alt="Slide 3">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>USG</h5>
                                        <p>Contoh gambar usg</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/detail_domba.jpg') }}" class="d-block w-100" alt="Slide 3">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 style="color: black;">Data domba</h5>
                                        <p style="color: black;">Tampilan detail domba pada website</p>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <div class="ratio ratio-16x9 w-100">
                            <iframe src="https://www.youtube.com/embed/XbubGcpVk1o"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <h4 class="text-center">Data</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card blue">
                                <div>
                                    <h4>Total Domba</h4>
                                    <p>{{ $summary->total_sheep }}</p>
                                </div>
                                <div class="icon">📋</div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card green">
                                <div>
                                    <h4>Domba Sehat</h4>
                                    <p>{{ $summary->total_sehat }}</p>
                                </div>
                                <div class="icon">🐏</div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card cyan">
                                <div>
                                    <h4>Domba hamil</h4>
                                    <p>{{ $summary->total_hamil }}</p>
                                </div>
                                <div class="icon">🐑</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <h4 class="text-center">Grafik</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="sheepChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<!-- Bootstrap JS (jika belum ada di template) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('sheepChart').getContext('2d');
    const sheepChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($sheepPerYear->pluck('year')) !!},
            datasets: [{
                label: 'Jumlah Domba',
                data: {!! json_encode($sheepPerYear->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah Domba' }
                },
                x: {
                    title: { display: true, text: 'Tahun' }
                }
            }
        }
    });
</script>

		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
              document.addEventListener("DOMContentLoaded", function() {
                  @if (Session::has('success'))
                      Swal.fire({
                          icon: 'success',
                          title: 'Sukses!',
                          text: '{{ Session::get('success') }}',
                          showConfirmButton: false,
                          timer: 3000
                      });
                  @endif
              });
          </script>

@endsection