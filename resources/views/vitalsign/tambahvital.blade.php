@extends('layouts.template')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <!-- <h1>Add Sheep</h1> -->
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add New Vital Sign</h5>
                        <form action="{{ route('vital-sign.store') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-6">
                                <label for="domba-select">Pilih Domba:</label>
                                <select class="form-select" id="domba-select" onchange="fetchDombaData()" name="id_domba">
                                    <option value="">Pilih Domba</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="inputAsesor" class="form-label">ASSESOR</label>
                                <input type="text" name="asesor" class="form-control" id="inputAsesor" required>
                            </div>
                            <div class="col-12">
                                <label for="inputTanggal-lahir" class="form-label">TANGGAL VITAL SIGN</label>
                                <input type="date" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                            </div>
                            <div class="col-3">
                                <label for="inputTanggal-lahir" class="form-label">DETAK JANTUNG</label>
                                <input type="text" name="detak" class="form-control" id="inputTanggal-lahir" required>
                            </div>
                            <div class="col-3">
                                <label for="inputTanggal-lahir" class="form-label">TEKANAN DARAH</label>
                                <input type="text" name="tekanan" class="form-control" id="inputTanggal-lahir" required>
                            </div>
                            <div class="col-3">
                                <label for="inputKondisi" class="form-label">KONDISI</label>
                                <select name="kondisi" class="form-select" id="inputKondisi" required>
                                    <option value="sehat">sehat</option>
                                    <option value="tidak sehat">tidak sehat</option>
                                </select>
                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">
                                <label for="inputTanggal-lahir" class="form-label">TEMPERATUR</label>
                                <input type="text" name="suhu" class="form-control" id="inputTanggal-lahir" required>
                            </div>
                            <div class="col-3">
                                <label for="inputTanggal-lahir" class="form-label">BERAT</label>
                                <input type="text" name="berat" class="form-control" id="inputTanggal-lahir" required>
                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">
                                <label for="inputTanggal-lahir" class="form-label">PERNAFASAN</label>
                                <input type="text" name="pernafasan" class="form-control" id="inputTanggal-lahir" required>
                            </div>
                            <div class="col-3">
                                <label for="inputKondisiMata" class="form-label">MATA</label>
                                <select name="mata" class="form-select" id="inputKondisiMata" required>
                                    <option value="normal">normal</option>
                                    <option value="berair">berair</option>
                                    <option value="kering">kering</option>
                                    <option value="bengkak">bengkak</option>
                                    <option value="merah">merah</option>
                                    <option value="berair lendir">berair lendir</option>
                                    <option value="rabun">rabun</option>
                                </select>
                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">
                                <label for="inputKondisiKuku" class="form-label">KUKU</label>
                                <select name="kuku" class="form-select" id="inputKondisiKuku" required>
                                    <option value="normal">normal</option>
                                    <option value="panjang">panjang</option>
                                    <option value="retak">retak</option>
                                    <option value="bengkak">bengkak</option>
                                    <option value="luka">luka</option>
                                    <option value="terinfeksi">terinfeksi</option>
                                    <option value="lembab">lembab</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="inputTanggal-lahir" class="form-label">LAINNYA</label>
                                <input type="text" name="lainnya" class="form-control" id="inputTanggal-lahir">
                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">

                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                            <p style="color: gray;"><b>*Note : Isi variabel hanya dengan angka, namun isi variabel detak jantung dengan contoh 80/110</b></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
@endsection