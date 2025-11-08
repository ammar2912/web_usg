<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data = DB::select("
            SELECT 
                (SELECT COUNT(id_domba) FROM sheep) AS total_sheep,
                (SELECT COUNT(DISTINCT id_domba) FROM vital_signs WHERE kondisi = 'sehat') AS total_sehat,
                (SELECT COUNT(DISTINCT id_domba) FROM riwayat_usg_domba WHERE hasil = 'hamil') AS total_hamil
        ");

        // karena DB::select() mengembalikan array of object, ambil index 0
        $summary = $data[0];

        $sheepPerYear = DB::table('sheep')
            ->select(DB::raw('YEAR(tanggal_lahir) as year'), DB::raw('COUNT(*) as total'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return view('dashboard', compact('summary', 'sheepPerYear'));
    }
}
