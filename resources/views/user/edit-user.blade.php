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
            <h5 class="card-title">Edit User</h5>
            <form action="{{ route('user.update', $user->id) }}" method="POST" class="row g-3">
              @csrf
              @method('PUT')

              <div class="col-6">
                <label for="inputnama" class="form-label">Nama User</label>
                <input type="text" name="nama" class="form-control" id="inputnama" value="{{ old('name', $user->name) }}">
              </div>

              <div class="col-6">
                <label for="inputemail" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" id="inputemail" value="{{ old('email', $user->email) }}">
              </div>

              <div class="col-6">
                <label for="inputpassword" class="form-label">Password</label>
                <input type="text" name="password" class="form-control" id="inputpassword">
              </div>

              <div class="col-3"></div>
              <button type="submit" class="btn btn-primary">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection