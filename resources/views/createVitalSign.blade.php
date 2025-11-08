@extends('layouts.template')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Add Sheep</h1>
    </div>
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Vital Sign</h5>
              <form action="" method="POST" class="row g-3">
                  @csrf
                  <div class="col-4">
                      <label for="inputId-domba" class="form-label">ID VITAL SIGN</label>
                      <input type="text" name="id_domba" class="form-control" id="inputId-domba" required>
                  </div>
                  <div class="col-4">
                      <label for="inputKeturunan" class="form-label">ID DOMBA</label>
                      <input type="text" name="keturunan" class="form-control" id="inputKeturunan">
                  </div>
                  <div class="col-4">
                      <label for="inputTanggal-lahir" class="form-label">ASSESOR</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-6">
                      <label for="inputTanggal-lahir" class="form-label">TANGGAL VITAL SIGN</label>
                      <input type="date" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-6">
                      <label for="inputTanggal-lahir" class="form-label">USIA DOMBA</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">VITAL SIGN</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">VITAL SIGN</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">HASIL</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                    
                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">VITAL SIGN</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">VITAL SIGN</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      
                  </div>
                  <div class="col-3">

                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">VITAL SIGN</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">VITAL SIGN</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      
                  </div>
                  <div class="col-3">

                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">VITAL SIGN</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      <label for="inputTanggal-lahir" class="form-label">VITAL SIGN</label>
                      <input type="text" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
                  </div>
                  <div class="col-3">
                      
                  </div>
                  <div class="col-3">

                  </div>
                  <div class="text-center">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn btn-secondary">Reset</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>
@endsection