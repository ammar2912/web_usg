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
            <h5 class="card-title">Add New Sheep</h5>
            <form action="{{ route('sheep.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
              @csrf
              <div class="col-3">
                <label for="inputId-domba" class="form-label">ID DOMBA</label>
                <input type="text" name="id_domba_first" class="form-control" id="inputId-domba" required>
              </div>
              <div class="col-3">
                <label class="form-label" style="visibility: hidden;">URUTAN LAHIR</label>
                <input type="text" name="id_domba_last" value="{{ $newIdDombaSuffix }}" class="form-control" readonly>
              </div>
              <div class="col-6">
                <label for="inputnamaDomba" class="form-label">NAMA DOMBA</label>
                <input type="text" name="namaDomba" class="form-control" id="inputnamaDomba">
              </div>
              <div class="col-6">
                <label for="inputidIndukJantan" class="form-label">ID INDUK JANTAN</label>
                <input type="text" name="idIndukJantan" class="form-control" id="inputidIndukJantan">
              </div>
              <div class="col-6">
                <label for="inputidIndukBetina" class="form-label">ID INDUK BETINA</label>
                <input type="text" name="idIndukBetina" class="form-control" id="inputidIndukBetina">
              </div>
              <div class="col-6">
                <label for="inputbobot" class="form-label">BOBOT LAHIR</label>
                <input type="number" name="bobot" class="form-control" id="inputbobot" step="0.01">
              </div>
              <div class="col-6">
                <label for="inputTanggal-lahir" class="form-label">TANGGAL LAHIR</label>
                <input type="date" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" required>
              </div>
              <div class="col-6">
                <label for="inputImage" class="form-label">UPLOAD GAMBAR</label>
                <input type="file" name="image" class="form-control" id="inputImage" accept="image/*" onchange="previewImage(event)">
                <label for="imagePreview" class="form-label">PREVIEW GAMBAR DOMBA</label>
                <img id="imagePreview" src="#" alt="Preview Gambar" style="max-width: 200px; display: none;" />
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

<script>
  function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
      var output = document.getElementById('imagePreview');
      output.src = reader.result;
      output.style.display = 'block'; // Show the image preview
    };
    reader.readAsDataURL(event.target.files[0]); // Convert image to base64 string
  }

  function resetPreview() {
    var output = document.getElementById('imagePreview');
    output.src = '#';
    output.style.display = 'none'; // Hide the image preview
  }
</script>
@endsection