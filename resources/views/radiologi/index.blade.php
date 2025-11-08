@extends('layouts.template')

@section('content')

<head>
    <!-- Existing head content -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<main id="main" class="main">
    <div class="row">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center p-2">
                <div>Daftar Radiologi</div>
                <div class="d-flex">
                    <div class="px-2">
                        <a href="{{ route('radiologi.create') }}" class="btn btn-primary">
                            <i class="fas fa-file-medical"></i>
                        </a>
                    </div>
                    <div class="px-2">
                        <button type="submit" form="bulk-action-form" name="action" value="edit" class="btn btn-success">
                            <i class="fas fa-file-signature"></i>
                        </button>
                    </div>
                    <div class="px-2">
                        <button type="submit" form="bulk-action-form" name="action" value="delete" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION CONTAINER TABEL -->
    <div class="d-flex">
        <div class="px-2">
            <button type="submit" form="bulk-action-form" name="action" value="chart" class="btn btn-primary">
                Lihat Riwayat USG
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <form id="bulk-action-form" action="{{ route('radiologi.bulkAction') }}" method="POST">
            @csrf
            <input type="hidden" name="action" id="action-input">
            <table class="table table-striped table-hover" id="table-list">
                <thead>
                    <tr>
                        <th></th>
                        <th>No.</th>
                        <th>ID Domba</th>
                        <th>Tanggal</th>
                        <th>Asesor</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($radiologis as $index => $radiologi)
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="{{ $radiologi->id_riwayat_usg_domba }}"></td>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $radiologi->id_domba }}</td>
                        <td>{{ $radiologi->tanggal_assesmen }}</td>
                        <td>{{ $radiologi->nama_assesor }}</td>
                        <td>{{ $radiologi->hasil }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('button[type="submit"][form="bulk-action-form"]').forEach(button => {
        button.addEventListener("click", function (e) {
            let checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            let selectedCount = checkboxes.length;

            if (selectedCount === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan pilih setidaknya satu catatan sebelum melanjutkan!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            } else if (button.value === "edit" && selectedCount > 1) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Hanya satu catatan yang bisa diedit dalam satu waktu!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            } else if (button.value === "chart" && selectedCount > 1) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Hanya satu catatan dalam satu waktu!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            } else if (button.value === "delete") {
                e.preventDefault();
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("action-input").value = "delete"; // Set action
                        document.getElementById("bulk-action-form").submit(); // Submit form
                    }
                });
            } else {
                // Set action sebelum submit form (untuk chart dan edit)
                document.getElementById("action-input").value = button.value;
                document.getElementById("bulk-action-form").submit();
            }
        });
    });

    // Checkbox Pilih Semua
    document.getElementById('select-all').addEventListener('change', function(e) {
        let checkboxes = document.querySelectorAll('input[name="selected[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });
});
</script>


@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session("error") }}',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@endsection