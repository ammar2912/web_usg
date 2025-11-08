<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheep extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_domba',
        'nama_domba',
        'id_induk_jantan', 
        'id_induk_betina',
        'bobot',
        'tanggal_lahir',
        'image',
        'qr_code',
    ];
}
