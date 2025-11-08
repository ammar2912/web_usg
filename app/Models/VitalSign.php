<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_domba',
        'tanggal',
        'asesor',
        'detak_jantung',
        'tekanan_darah',
        'kondisi',
        'suhu',
        'berat',
        'pernafasan',
        'mata',
        'kuku',
        'lainnya',
    ];
}
