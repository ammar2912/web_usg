<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\assesmen;
use Illuminate\Http\Request;

class AssesmenAPIController extends Controller
{
    public function index()
    {
        $assesmen = assesmen::all();
        return response()->json($assesmen);
    }

    public function show($id)
    {
        $assesmen = assesmen::find($id);
        if (!$assesmen) {
            return response()->json(['message' => 'Assesmen not found'], 404);
        }
        return response()->json($assesmen);
    }
}