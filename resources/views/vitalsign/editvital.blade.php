@extends('layouts.template')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Vital Sign</h5>
                        <form action="{{ route('vital-sign.update', $vitalSign->id) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
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
                                <label for="asesor" class="form-label">Asesor</label>
                                <input type="text" class="form-control" id="asesor" name="asesor" value="{{ old('asesor', $vitalSign->asesor) }}">
                            </div>
                            <div class="col-md-12">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal', $vitalSign->tanggal) }}">
                            </div>
                            <div class="col-3">
                                <label for="inputDetak" class="form-label">DETAK JANTUNG</label>
                                <input type="text" name="detak" class="form-control" id="inputDetak" value="{{ old('detak_jantung', $vitalSign->detak_jantung) }}" required>
                            </div>
                            <div class="col-3">
                                <label for="inputTekanan" class="form-label">TEKANAN DARAH</label>
                                <input type="text" name="tekanan" class="form-control" id="inputTekanan" value="{{ old('tekanan_darah', $vitalSign->tekanan_darah) }}" required>
                            </div>
                            <div class="col-3">
                                <label for="inputKondisi" class="form-label">KONDISI</label>
                                <select name="kondisi" class="form-select" id="inputKondisi" required>
                                    <option value="sehat" {{ old('kondisi', $vitalSign->kondisi) == 'sehat' ? 'selected' : '' }}>Sehat</option>
                                    <option value="tidak sehat" {{ old('kondisi', $vitalSign->kondisi) == 'tidak sehat' ? 'selected' : '' }}>Tidak Sehat</option>
                                </select>
                            </div>
                            <div class="col-3"></div>
                            <div class="col-3">
                                <label for="inputSuhu" class="form-label">TEMPERATUR</label>
                                <input type="text" name="suhu" class="form-control" id="inputSuhu" value="{{ old('suhu', $vitalSign->suhu) }}" required>
                            </div>
                            <div class="col-3">
                                <label for="inputBerat" class="form-label">BERAT</label>
                                <input type="text" name="berat" class="form-control" id="inputBerat" value="{{ old('berat', $vitalSign->berat) }}" required>
                            </div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3">
                                <label for="inputPernafasan" class="form-label">PERNAFASAN</label>
                                <input type="text" name="pernafasan" class="form-control" id="inputPernafasan" value="{{ old('pernafasan', $vitalSign->pernafasan) }}" required>
                            </div>
                            <div class="col-3">
                                <label for="inputKondisiMata" class="form-label">MATA</label>
                                <select name="mata" class="form-select" id="inputKondisiMata" required>
                                    <option value="normal" {{ old('mata', $vitalSign->mata) == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="berair" {{ old('mata', $vitalSign->mata) == 'berair' ? 'selected' : '' }}>Berair</option>
                                    <option value="kering" {{ old('mata', $vitalSign->mata) == 'kering' ? 'selected' : '' }}>Kering</option>
                                    <option value="bengkak" {{ old('mata', $vitalSign->mata) == 'bengkak' ? 'selected' : '' }}>Bengkak</option>
                                    <option value="merah" {{ old('mata', $vitalSign->mata) == 'merah' ? 'selected' : '' }}>Merah</option>
                                    <option value="berair lendir" {{ old('mata', $vitalSign->mata) == 'berair lendir' ? 'selected' : '' }}>Berair Lendir</option>
                                    <option value="rabun" {{ old('mata', $vitalSign->mata) == 'rabun' ? 'selected' : '' }}>Rabun</option>
                                </select>
                            </div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3">
                                <label for="inputKondisiKuku" class="form-label">KUKU</label>
                                <select name="kuku" class="form-select" id="inputKondisiKuku" required>
                                    <option value="normal" {{ old('kuku', $vitalSign->kuku) == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="panjang" {{ old('kuku', $vitalSign->kuku) == 'panjang' ? 'selected' : '' }}>Panjang</option>
                                    <option value="retak" {{ old('kuku', $vitalSign->kuku) == 'retak' ? 'selected' : '' }}>Retak</option>
                                    <option value="bengkak" {{ old('kuku', $vitalSign->kuku) == 'bengkak' ? 'selected' : '' }}>Bengkak</option>
                                    <option value="luka" {{ old('kuku', $vitalSign->kuku) == 'luka' ? 'selected' : '' }}>Luka</option>
                                    <option value="terinfeksi" {{ old('kuku', $vitalSign->kuku) == 'terinfeksi' ? 'selected' : '' }}>Terinfeksi</option>
                                    <option value="lembab" {{ old('kuku', $vitalSign->kuku) == 'lembab' ? 'selected' : '' }}>Lembab</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="inputLainnya" class="form-label">LAINNYA</label>
                                <input type="text" name="lainnya" class="form-control" id="inputLainnya" value="{{ old('lainnya', $vitalSign->lainnya) }}">
                            </div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
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