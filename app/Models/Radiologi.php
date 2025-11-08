<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radiologi extends Model
{
    use HasFactory;
    protected $table = 'riwayat_usg_domba';
    protected $primaryKey = 'id_riwayat_usg_domba';
    protected $fillable = [
        'id_domba',
        'nama_assesor',
        'tanggal_assesmen',
        'gambar_usg',
        'hasil',
        'keterangan_lain'
    ];
}
