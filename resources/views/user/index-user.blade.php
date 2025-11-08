@extends('layouts.template')

@section('content')

<!-- <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head> -->

<main id="main" class="main">
    <div class="row">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center p-2">
                <div>Daftar Tim Rekam Medik</div>
                <div class="d-flex">
                    <div class="px-2">
                        <a href="{{ route('user.create') }}" class="btn btn-primary">
                            <i class="fas fa-file-medical"></i>
                        </a>
                    </div>
                    <div class="px-2">
                        <button type="submit" form="bulk-action-form" name="action" value="edit" class="btn btn-success">
                            <i class="fas fa-file-signature"></i>
                        </button>
                    </div>
                    <div class="px-2">
                        <button type="button" id="delete-button" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="bulk-action-form" action="{{ route('user.bulkAction') }}" method="POST">
        @csrf
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="select-all"></th>
                        <th scope="col">#</th>
                        <th scope="col">Nama User</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $key => $item)
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="{{ $item->id }}"></td>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Select All Checkbox
    document.getElementById("select-all").addEventListener("change", function (e) {
        let checkboxes = document.querySelectorAll('input[name="selected[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });

    // Tombol Delete
    document.getElementById("delete-button").addEventListener("click", function () {
        let form = document.getElementById("bulk-action-form");
        let selected = document.querySelectorAll('input[name="selected[]"]:checked');

        console.log("Selected items:", selected.length);  // Debugging

        if (selected.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "Tidak ada data yang dipilih",
                text: "Silakan pilih setidaknya satu data untuk dihapus.",
            });
            return;
        }

        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("Hapus dikonfirmasi"); // Debugging
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "action";
                input.value = "delete";
                form.appendChild(input);
                form.submit();
            }
        });
    });
});

</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if (session('success'))
            Swal.fire({
                icon: "success",
                title: "Sukses!",
                text: "{{ session('success') }}",
                confirmButtonText: "OK"
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "{{ session('error') }}",
                confirmButtonText: "OK"
            });
        @endif
    });
</script>

@endsection
