@extends('layouts.template')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Radiologi</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Radiologi</h5>
                        <form action="{{ route('radiologi.update', $radiologi->id_riwayat_usg_domba) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <label for="id_radiologi" class="form-label">ID Radiologi</label>
                                <input type="text" class="form-control" id="id_radiologi" name="id_radiologi" value="{{ old('id_riwayat_usg_domba', $radiologi->id_riwayat_usg_domba) }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="domba-select">Pilih Domba:</label>
                                <select class="form-select" id="domba-select" name="id_domba" required>
                                    <option value="">Pilih Domba</option>
                                    @foreach ($dombaList as $domba)
                                    <option value="{{ $domba->id_domba }}" {{ $domba->id_domba == $selectedDombaId ? 'selected' : '' }}>
                                        {{ $domba->nama_domba }} - {{ $domba->id_domba }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_assesmen" class="form-label">Tanggal Assesmen</label>
                                <input type="date" class="form-control" id="tanggal_assesmen" name="tanggal_assesmen" value="{{ old('tanggal_assesmen', $radiologi->tanggal_assesmen) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="assesor" class="form-label">Nama Assesor</label>
                                <input type="text" class="form-control" id="assesor" name="assesor" value="{{ old('nama_assesor', $radiologi->nama_assesor) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="uploadGambar" class="form-label">Upload Gambar</label>
                                <input type="file" class="form-control" id="uploadGambar" name="uploadGambar" accept=".jpg, .jpeg, .png">
                                @if($radiologi->gambar_usg)
                                <img src="{{ url($radiologi->gambar_usg) }}" alt="gambar radiologi" style="margin-top: 10px; max-width: 100%;">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" value="{{ old('hasil', $radiologi->hasil) }}" readonly>
                            </div>
                            <div class="col-md-12">
                                <label for="keterangan" class="form-label">Keterangan Lain</label>
                                <textarea class="form-control" placeholder="Masukkan keterangan lain" id="keterangan" name="keterangan" style="height: 100px">{{ old('keterangan', $radiologi->keterangan) }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    document.getElementById('uploadGambar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.querySelector('img[alt="gambar radiologi"]');
                if (imgElement) {
                    imgElement.src = e.target.result;
                } else {
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.alt = 'gambar radiologi';
                    newImg.style.marginTop = '10px';
                    newImg.style.maxWidth = '100%';
                    document.getElementById('uploadGambar').parentNode.appendChild(newImg);
                }
            };
            reader.readAsDataURL(file);

            // Upload image to Flask API and get prediction
            const formData = new FormData();
            formData.append('file', file);

            fetch('https://isusg-ai.research-ai.my.id/predict', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('status').value = data.prediction;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectedDombaId = '{{ $selectedDombaId }}';
        fetchDombaList(selectedDombaId);
    });

    function fetchDombaList(selectedDombaId = '') {
        fetch('/domba/select')
            .then(response => response.json())
            .then(data => {
                const dombaSelect = document.getElementById('domba-select');
                dombaSelect.innerHTML = '<option value="">Pilih Domba</option>'; // Reset dropdown

                data.forEach(domba => {
                    const option = document.createElement('option');
                    option.value = domba.id_domba;
                    option.text = `${domba.nama_domba} - ${domba.id_domba}`;

                    // Tandai opsi yang sudah dipilih sebelumnya
                    if (domba.id_domba === selectedDombaId) {
                        option.selected = true;
                    }

                    dombaSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching domba data:', error);
            });
    }
</script>
@endsection