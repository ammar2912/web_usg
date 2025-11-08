@extends('layouts.template')

@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Sheep</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sheep.index') }}">Sheep</a></li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </nav>
  </div>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Sheep</h5>
            <form action="{{ route('sheep.update', $sheep->id) }}" method="POST" class="row g-3" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="col-6">
                <label for="inputId-domba" class="form-label">ID DOMBA</label>
                <input type="text" name="id_domba" class="form-control" id="inputId-domba" value="{{ $sheep->id_domba }}" readonly>
              </div>
              <div class="col-6">
                <label for="inputnamaDomba" class="form-label">NAMA DOMBA</label>
                <input type="text" name="namaDomba" class="form-control" id="inputnamaDomba" value="{{ $sheep->nama_domba }}">
              </div>
              <div class="col-6">
                <label for="inputidIndukJantan" class="form-label">ID INDUK JANTAN</label>
                <input type="text" name="idIndukJantan" class="form-control" id="inputidIndukJantan" value="{{ $sheep->id_induk_jantan }}">
              </div>
              <div class="col-6">
                <label for="inputidIndukBetina" class="form-label">ID INDUK BETINA</label>
                <input type="text" name="idIndukBetina" class="form-control" id="inputidIndukBetina" value="{{ $sheep->id_induk_betina }}">
              </div>
              <div class="col-6">
                <label for="inputbobot" class="form-label">BOBOT LAHIR</label>
                <input type="number" name="bobot" class="form-control" id="inputbobot" step="0.01" value="{{ $sheep->bobot }}">
              </div>
              <div class="col-6">
                <label for="inputTanggal-lahir" class="form-label">TANGGAL LAHIR</label>
                <input type="date" name="tanggal_lahir" class="form-control" id="inputTanggal-lahir" value="{{ $sheep->tanggal_lahir }}" required>
              </div>
              <div class="col-6">
                <label for="inputImage" class="form-label">GAMBAR DOMBA</label>
                <input type="file" name="image" class="form-control" id="inputImage" accept="image/*" onchange="previewImage(event)">
                @if($sheep->image)
                <label for="gambarLama" class="form-label">Gambar lama</label><br/>
                <img id="gambarLama" src="{{ url($sheep->image) }}" alt="Gambar Domba" style="max-width: 200px;"><br/>
                @endif
                <label for="imagePreview" class="form-label">Gambar baru</label>
                <img id="imagePreview" src="#" alt="Preview Gambar" style="max-width: 200px;" />
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('sheep.index') }}" class="btn btn-secondary">Cancel</a>
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