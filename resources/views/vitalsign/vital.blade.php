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
                <div>Daftar Vital Sign</div>
                <div class="d-flex">
                    <div class="px-2">
                        <a href="{{ route('vital-sign.create') }}" class="btn btn-primary">
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
                Lihat Chart Domba
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <form id="bulk-action-form" action="{{ route('vital-sign.bulkAction') }}" method="POST">
            @csrf
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
                    @foreach($vitalsigns as $index => $vitalsign)
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="{{ $vitalsign->id }}"></td>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $vitalsign->id_domba }}</td>
                        <td>{{ $vitalsign->tanggal }}</td>
                        <td>{{ $vitalsign->asesor }}</td>
                        <td>{{ $vitalsign->kondisi }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</main>

<script>
    document.getElementById('select-all').addEventListener('change', function(e) {
        let checkboxes = document.querySelectorAll('input[name="selected[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });
</script>

@if(session('error'))
<script>
    alert('{{ session('
        error ') }}');
</script>
@endif

@if(session('success'))
<script>
    alert('{{ session('
        success ') }}');
</script>
@endif

@endsection