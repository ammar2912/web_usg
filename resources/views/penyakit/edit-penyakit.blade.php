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
        <form action="{{ route('edit_data', $data->ID_ASSESMEN) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label for="id_assesmen" class="form-label text-uppercase">ID asesmen</label>
                                    <input type="text" id="id_assesmen" placeholder="masukan ID ASESMEN" class="form-control" name="id_assesmen" value="{{$data->ID_ASSESMEN}}" readonly>
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="id_domba" class="form-label text-uppercase">ID domba</label>
                                    <input type="text" id="id_domba" placeholder="masukan ID domba" class="form-control" name="id_domba" readonly value="{{ $data->ID_DOMBA }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="tanggal" class="form-label text-uppercase">tanggal assesmen</label>
                                    <input type="date" name="tanggal_assesmen" id="tanggal" placeholder="tanggal" class="form-control" readonly value="{{ $data->TANGGAL_ASSESMEN }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="usia_domba" class="form-label text-uppercase">usia domba</label>
                                    <input type="text" name="usia_domba" id="usia_domba" placeholder="usia domba" class="form-control" readonly value="{{ $data->USIA_DOMBA }}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <label for="assesor" class="form-label">nama assesor</label>
                                <input type="text" id="assesor" placeholder="nama assesor" class="form-control" name="assesor" readonly value="{{ $data->NAMA_ASSESOR }}">
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
                                    <input type="text" name="gejala1" id="gejala1" placeholder="gejala 1" class="form-control"  value="{{ $data->GEJALA_1 }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="gejala2" class="form-label text-uppercase">gejala 2</label>
                                    <input type="text" name="gejala2" id="gejala2" placeholder="gejala 2" class="form-control"  value="{{ $data->GEJALA_2 }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="gejala3" class="form-label text-uppercase">gejala 3</label>
                                    <input type="text" name="gejala3" id="gejala3" placeholder="gejala 3" class="form-control"  value="{{ $data->GEJALA_3 }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="gejala4" class="form-label text-uppercase">gejala 4</label>
                                    <input type="text" name="gejala4" id="gejala4" placeholder="gejala 4" class="form-control"  value="{{ $data->GEJALA_4 }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="gejala5" class="form-label text-uppercase">gejala 5</label>
                                    <input type="text" name="gejala5" id="gejala5" placeholder="gejala 5" class="form-control"  value="{{ $data->GEJALA_5 }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="gejala6" class="form-label text-uppercase">gejala 6</label>
                                    <input type="text" name="gejala6" id="gejala6" placeholder="gejala 6" class="form-control" value="{{ $data->GEJALA_6 }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="gejala7" class="form-label text-uppercase">gejala 7</label>
                                    <input type="text" name="gejala7" id="gejala7" placeholder="gejala 7" class="form-control" value="{{ $data->GEJALA_7 }}">
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="gejala8" class="form-label text-uppercase">gejala 8</label>
                                    <input type="text" name="gejala8" id="gejala8" placeholder="gejala 8" class="form-control" value="{{ $data->GEJALA_8 }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="keterangan" class="form-label">keterangan lain</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 300px" class="form-control" name="keterangan" >{{ $data->KETERANGAN }}</textarea>
                                <label for="floatingTextarea2">ketik disini</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-auto" style="width: 300px;">
                <button type="submit" class="btn btn-primary" style="width: 316px">edit</button>
            </div>
        </form>
    </div>

</main>
@endsection
