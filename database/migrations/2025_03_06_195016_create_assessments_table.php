<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('radiologi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_domba');
            $table->string('nama_assesor');
            $table->date('tanggal_assesmen');
            $table->string('gambar_usg');
            $table->string('hasil')->nullable();
            $table->text('keterangan_lain')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radiologi');
    }
};
