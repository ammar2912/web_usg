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
                        <h5 class="card-title">Tambah User</h5>
                        <form action="{{ route('user.store') }}" method="POST" class="row g-3">
                            @csrf

                            <div class="col-6">
                                <label for="inputnama" class="form-label">Nama User</label>
                                <input type="text" name="nama" class="form-control" id="inputnama">
                            </div>

                            <!-- <div class="col-6">
                                <label for="inputrole" class="form-label">Role</label>
                                <select name="role" class="form-select" id="inputrole">
                                    <option value="admin">Admin</option>
                                    <option value="peternak">Peternak</option>
                                </select>
                            </div> -->

                            <div class="col-6">
                                <label for="inputemail" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" id="inputemail">
                            </div>

                            <div class="col-6">
                                <label for="inputpassword" class="form-label">Password</label>
                                <input type="text" name="password" class="form-control" id="inputpassword">
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