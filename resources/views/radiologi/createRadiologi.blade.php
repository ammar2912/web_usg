@extends('layouts.template')
@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center p-2">
                <div>tambah radiologi</div>
            </div>
        </div>
    </div>
    <div class="row">
    <form id="radiologiForm" action="{{ route('radiologi.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <label for="domba-select">Pilih Domba:</label>
                                    <select class="form-select" id="domba-select" onchange="fetchDombaData()" name="id_domba">
                                        <option value="">Pilih Domba</option>
                                    </select>
                                </div>
                                <div class="col-md-12 my-2">
                                    <label for="tanggal" class="form-label text-uppercase">tanggal assesmen</label>
                                    <input type="date" name="tanggal_assesmen" id="tanggal" placeholder="tanggal"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 my-2">
    <label for="uploadGambar" class="form-label text-uppercase">Upload Gambar</label>
    <input type="file" name="uploadGambar" id="uploadGambar" class="form-control" accept=".jpg, .jpeg, .png" required>
    <img id="gambarUpload" alt="gambar upload" style="margin-top: 10px; max-width: 100%;">
</div>
                                <div class="col-md-6 my-2">
                                    <label for="status" class="form-label text-uppercase">Status</label>
                                    <input type="text" name="status" id="status" placeholder="Status"
                                        class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <label for="assesor" class="form-label">nama assesor</label>
                                <input type="text" id="assesor" placeholder="nama assesor" class="form-control"
                                    name="assesor" required>
                            </div>
                            <br />
                            <div class="col-md-12">
                                <label for="keterangan" class="form-label">keterangan lain</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 300px"
                                        class="form-control" name="keterangan"></textarea>
                                    <label for="floatingTextarea2">ketik disini</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-5">
                                <div class="row">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-auto" style="width: 300px;">
            <button type="button" id="tambahdatabtn" class="btn btn-primary" style="width: 316px">Tambah</button>

            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchDombaList();
    });

    function fetchDombaList() {
        fetch('/domba/select')
            .then(response => response.json())
            .then(data => {
                const dombaSelect = document.getElementById('domba-select');
                dombaSelect.innerHTML = '<option value="">Pilih Domba</option>'; // Reset dropdown
                data.forEach(domba => {
                    const option = document.createElement('option');
                    option.value = domba.id_domba;
                    option.text = `${domba.nama_domba} - ${domba.id_domba}`;
                    dombaSelect.appendChild(option);
                });
            });
    }
</script>

<script>
    document.getElementById('uploadGambar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('gambarUpload').src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Tampilkan SweetAlert loading
            Swal.fire({
                title: "Memproses gambar...",
                text: "Silakan tunggu",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Upload image to Flask API and get prediction
            const formData = new FormData();
            formData.append('file', file);

            fetch('https://141.11.160.139:5000/predict', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('status').value = data.prediction;
                    
                    // Tutup SweetAlert dan tampilkan hasil
                    Swal.fire({
                        icon: 'success',
                        title: 'Prediksi Selesai!',
                        text: `Status: ${data.prediction}`,
                        timer: 3000,
                        showConfirmButton: false
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Tutup loading dan tampilkan pesan error
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal memproses gambar!',
                        text: 'Terjadi kesalahan, coba lagi.',
                    });
                });
        }
    });
</script>
<script>
    document.getElementById("tambahdatabtn").addEventListener("click", function (event) {
    event.preventDefault(); // Mencegah submit langsung

    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data akan disimpan ke dalam sistem.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, simpan!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.getElementById("radiologiForm"); // Cari form berdasarkan ID

            if (form) {
                form.submit();
            } else {
                Swal.fire("Error", "Form tidak ditemukan!", "error");
            }
        }
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tambahkan di dalam <body> atau bagian script -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@endsection
