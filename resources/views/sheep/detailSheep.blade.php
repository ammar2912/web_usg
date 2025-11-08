@extends('layouts.template')

@section('content')
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">QR Code Untuk Domba Dengan Id : {{ $sheep->id_domba }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                @php
    $imageExists = isset($sheep) && $sheep->image && file_exists(public_path($sheep->image));
@endphp

@if($imageExists)
    <img id="imagePreview" src="{{ url($sheep->image) }}" alt="Gambar Domba" style="max-width: 560px;" />
@else
    <img id="imagePreview" src="{{ asset('images/sheep/Domba.png') }}" alt="Preview Gambar" style="max-width: 560px;" />
@endif
                            </div>
                            <div class="col-md-6">
                                <div class="row-md-6">
                                    <button onclick="printQrCode()" class="btn btn-primary">Print QR Code</button><br />
                                </div>
                                <div class="row-md-6" id="qrcodeSection">
                                    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" style="max-width: 135px;">
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p><strong>Id Domba:</strong> {{ $sheep->id_domba }}</p>
                            <p><strong>Nama Domba:</strong> {{ $sheep->nama_domba }}</p>
                            <p><strong>Id Induk Domba Jantan:</strong> {{ $sheep->id_induk_jantan }}</p>
                            <p><strong>Id Induk Domba Betina:</strong> {{ $sheep->id_induk_betina }}</p>
                            <p><strong>Bobot:</strong> {{ $sheep->bobot }}</p>
                            <p><strong>Tanggal Lahir:</strong> {{ $sheep->tanggal_lahir }}</p>
                        </div>

                        <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th style="padding: 8px; text-align: center;">Chart Vital Sign</th>
                                    <th style="padding: 8px; text-align: center;">Riwayat USG</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">
                                        <!-- Kondisi jika $result tidak null -->
                                        @if ($result)
                                        <a class="btn btn-primary" href="/vital-sign/chart/{{ $result->id }}">
                                            Lihat Chart Domba
                                        </a>
                                        @else
                                        <div class="alert alert-warning" role="alert">
                                            Chart Domba tidak ditemukan.
                                        </div>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($hasil)
                                        <a class="btn btn-primary" href="/radiologi/riwayat/{{ $hasil->id_riwayat_usg_domba }}">
                                            Lihat Riwayat USG
                                        </a>
                                        @else
                                        <div class="alert alert-warning" role="alert">
                                            Riwayat USG tidak ditemukan.
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <br />
                        <a href="{{ route('sheep.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    function printQrCode() {
        const printContents = document.getElementById('qrcodeSection').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML =
            `<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                ${printContents}
            </div>`;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

@endsection