<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assesmen extends Model
{
    use HasFactory;

    protected $table = 'assesmen';
    protected $primaryKey = 'ID_ASSESMEN';
    public $incrementing = false; // If your primary key is not auto-incrementing
    protected $keyType = 'string'; // If your primary key is not an integer

    protected $fillable = [
        'ID_ASSESMEN',
        'ID_DOMBA',
        'NAMA_ASSESOR',
        'TANGGAL_ASSESMEN',
        'USIA_DOMBA',
        'GEJALA_1',
        'GEJALA_2',
        'GEJALA_3',
        'GEJALA_4',
        'GEJALA_5',
        'GEJALA_6',
        'GEJALA_7',
        'GEJALA_8',
        'KETERANGAN' // Jika ada field keterangan
    ];
    public $timestamps = false;

}
