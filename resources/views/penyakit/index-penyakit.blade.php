@extends('layouts.template')

@section('content')
    <main id="main" class="main">
        <form action="{{ route('hapus_data') }}" method="POST">
            @csrf
            <div class="row">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center p-2">
                        <div>daftar assesmen</div>
                        <div class="d-flex">
                            <div class="px-2">
                                <a href="{{ route('form_tambah') }}" class="btn btn-primary">tambah</a>
                            </div>
                            <div class="px-2">
                                <button type="button" id="editButton" class="btn btn-success">Edit</button>
                            </div>
                            <div class="px-2">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">#</th>
                            <th scope="col">id assesmen</th>
                            <th scope="col">id domba</th>
                            <th scope="col">tanngal</th>
                            <th scope="col">assesor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td><input class="form-check-input" type="checkbox" value="{{ $item->ID_ASSESMEN }}"
                                        id="flexCheckDefault" name="selectedItems[]"></td>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $item->ID_ASSESMEN }}</td>
                                <td>{{ $item->ID_DOMBA }}</td>
                                <td>{{ $item->TANGGAL_ASSESMEN }}</td>
                                <td>{{ $item->NAMA_ASSESOR }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </main>
    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            let selected = document.querySelectorAll('input[name="selectedItems[]"]:checked');
            if (selected.length === 1) {
                let id = selected[0].value;
                window.location.href = '{{ url('/list-penyakit/form-edit') }}/' + id;
            } else {
                alert('Please select exactly one item to edit.');
            }
        });
    </script>
@endsection
