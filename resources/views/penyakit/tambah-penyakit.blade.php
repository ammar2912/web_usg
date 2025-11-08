@extends('layouts.template')
@section('content')
    <main id="main" class="main">
        <div class="row">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center p-2">
                    <div>daftar assesmen</div>
                </div>
              </div>
        </div>
        <div class="row">
            <form action="{{ route('simpan_data') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        <label for="id_assesmen" class="form-label text-uppercase">ID asesmen</label>
                                        <input type="text" id="id_assesmen" placeholder="masukan ID ASESMEN" class="form-control" name="id_assesmen" required>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="id_domba" class="form-label text-uppercase">ID Domba</label>
                                        <select id="id_domba" name="id_domba" class="form-select" required>
                                            <option value="">-- Pilih Domba --</option>
                                            @foreach($dombas as $domba)
                                                <option value="{{ $domba->id_domba }}" data-tanggal="{{ $domba->tanggal_lahir }}">
                                                    {{ $domba->id_domba }} - {{ $domba->nama_domba }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="tanggal" class="form-label text-uppercase">tanggal assesmen</label>
                                        <input type="date" name="tanggal_assesmen" id="tanggal" placeholder="tanggal" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="usia_domba" class="form-label text-uppercase">usia domba</label>
                                        <input style="background-color: #f8f9fa;" type="text" name="usia_domba" id="usia_domba" placeholder="usia domba" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <label for="assesor" class="form-label">nama assesor</label>
                                    <input type="text" id="assesor" placeholder="nama assesor" class="form-control" name="assesor" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        <label for="gejala1" class="form-label text-uppercase">gejala 1</label>
                                        <input type="text" name="gejala1" id="gejala1" placeholder="gejala 1" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="gejala2" class="form-label text-uppercase">gejala 2</label>
                                        <input type="text" name="gejala2" id="gejala2" placeholder="gejala 2" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="gejala3" class="form-label text-uppercase">gejala 3</label>
                                        <input type="text" name="gejala3" id="gejala3" placeholder="gejala 3" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="gejala4" class="form-label text-uppercase">gejala 4</label>
                                        <input type="text" name="gejala4" id="gejala4" placeholder="gejala 4" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="gejala5" class="form-label text-uppercase">gejala 5</label>
                                        <input type="text" name="gejala5" id="gejala5" placeholder="gejala 5" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="gejala6" class="form-label text-uppercase">gejala 6</label>
                                        <input type="text" name="gejala6" id="gejala6" placeholder="gejala 6" class="form-control">
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="gejala7" class="form-label text-uppercase">gejala 7</label>
                                        <input type="text" name="gejala7" id="gejala7" placeholder="gejala 7" class="form-control">
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="gejala8" class="form-label text-uppercase">gejala 8</label>
                                        <input type="text" name="gejala8" id="gejala8" placeholder="gejala 8" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="keterangan" class="form-label">keterangan lain</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 300px" class="form-control" name="keterangan"></textarea>
                                    <label for="floatingTextarea2">ketik disini</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto" style="width: 300px;">
                    <button type="submit" class="btn btn-primary" style="width: 316px">tambah</button>
                </div>
            </form>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const idDombaSelect = document.getElementById("id_domba");
    const usiaInput = document.getElementById("usia_domba");

    idDombaSelect.addEventListener("change", function() {
        const selectedOption = idDombaSelect.options[idDombaSelect.selectedIndex];
        const tanggalLahir = selectedOption.getAttribute("data-tanggal");

        if (tanggalLahir) {
            const lahir = new Date(tanggalLahir);
            const sekarang = new Date();
            let tahun = sekarang.getFullYear() - lahir.getFullYear();
            let bulan = sekarang.getMonth() - lahir.getMonth();

            if (bulan < 0) {
                tahun--;
                bulan += 12;
            }

            usiaInput.value = `${tahun} tahun ${bulan} bulan`;
        } else {
            usiaInput.value = '';
        }
    });
});
</script>
        </div>

    </main>
@endsection
