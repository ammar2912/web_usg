<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Sheep;
use Illuminate\Http\Request;

class SheepAPIController extends Controller
{
    public function index()
    {
        $sheep = Sheep::all();
        return response()->json($sheep);
    }

    public function show($id)
    {
        $sheep = Sheep::find($id);
        if (!$sheep) {
            return response()->json(['message' => 'Sheep not found'], 404);
        }
        return response()->json($sheep);
    }
}