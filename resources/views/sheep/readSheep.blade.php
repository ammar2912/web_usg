<!-- resources/views/sheep/index.blade.php -->

@extends('layouts.template')

@section('content')

<head>
    <!-- Existing head content -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Add jQuery before your custom JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<main id="main" class="main">
    <div class="row">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center p-2">
                <div>Daftar Domba</div>
                <!-- Scan QR Code button triggers the modal -->
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#cameraModal">
                    <i class="fas fa-camera"></i> Scan QR Code
                </button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br />
                        <a href="{{ route('sheep.create') }}" class="btn btn-primary mb-3">Tambah Domba</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>ID Domba</th>
                                    <th>Nama Domba</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = ($sheep->currentPage() - 1) * $sheep->perPage() + 1; ?>
                                @foreach ($sheep as $item)
                                <tr>
                                    <td> {{ $no }} </td>
                                    <td>{{ $item->id_domba }}</td>
                                    <td>{{ $item->nama_domba }}</td>
                                    <td>{{ $item->tanggal_lahir }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('sheep.qrcode', $item->id_domba) }}">Lihat</a>
                                        <a class="btn btn-primary" href="{{ route('sheep.edit', $item->id) }}">Edit</a>
                                        <form action="{{ route('sheep.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div class="container d-flex justify-content-center">
                            {{ $sheep->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Camera Modal -->
        <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cameraModalLabel">Scan QR Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <video id="video" width="100%" height="200" autoplay></video>
                        <canvas id="canvas" style="display: none;" willReadFrequently="true"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Load QR Code Scanner Library -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

    <script>
    let videoStream = null; // Global variable to hold video stream

    // Event listener to start the camera when the modal is shown (using jQuery)
    $('#cameraModal').on('shown.bs.modal', function () {
        startCamera(); // Start the camera when the modal is shown
    });

    // Event listener to stop the camera when the modal is hidden (using jQuery)
    $('#cameraModal').on('hidden.bs.modal', function () {
        stopCamera(); // Stop the camera when the modal is closed
    });

    // Setup kamera
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    // Start camera stream
    function startCamera() {
        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: "environment" // Using the rear camera if available
            }
        })
        .then(function(stream) {
            video.srcObject = stream;
            video.setAttribute("playsinline", true); // Required for iOS

            // Wait until the video metadata is loaded to get the video dimensions
            video.onloadedmetadata = function() {
                // Set canvas dimensions after video metadata is loaded
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                requestAnimationFrame(scanQRCode); // Start scanning
            };

            videoStream = stream; // Save the stream to stop it later
        })
        .catch(function(err) {
            console.error("Error accessing camera: ", err);
        });
    }

    // Stop camera stream
    function stopCamera() {
        if (videoStream) {
            const tracks = videoStream.getTracks();
            tracks.forEach(track => track.stop()); // Stop all tracks
            videoStream = null;
        }
    }

    // Function to scan QR code
    function scanQRCode() {
        if (canvas.width && canvas.height) {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, canvas.width, canvas.height);

            if (code) {
                // QR Code detected, extract ID
                const id = code.data; // ID Domba is encoded in the QR Code
                console.log("ID Domba: ", id);

                // Redirect to domba details page using the correct route
                window.location.href = `/detail-sheep/${id}`; // Correct route syntax for JavaScript
            } else {
                // Continue scanning
                requestAnimationFrame(scanQRCode);
            }
        } else {
            // Retry scanning until video dimensions are available
            requestAnimationFrame(scanQRCode);
        }
    }
    </script>
  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <script>
              document.addEventListener("DOMContentLoaded", function() {
                  let deleteButtons = document.querySelectorAll(".delete-btn");

                  deleteButtons.forEach(function(button) {
                      button.addEventListener("click", function() {
                          let id = this.getAttribute("data-id");

                          Swal.fire({
                              title: "Apakah Anda yakin?",
                              text: "Data yang dihapus tidak dapat dikembalikan!",
                              icon: "warning",
                              showCancelButton: true,
                              confirmButtonColor: "#d33",
                              cancelButtonColor: "#3085d6",
                              confirmButtonText: "Ya, hapus!",
                              cancelButtonText: "Batal"
                          }).then((result) => {
                              if (result.isConfirmed) {
                                  document.getElementById("delete-form-" + id).submit();
                              }
                          });
                      });
                  });
              });
          </script>

</main>

@endsection
