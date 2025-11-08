<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VitalSign;
use Illuminate\Http\Request;

class VitalSignAPIController extends Controller
{
    public function index()
    {
        $vital = VitalSign::all();
        return response()->json($vital);
    }

    public function show($id)
    {
        $vital = VitalSign::find($id);
        if (!$vital) {
            return response()->json(['message' => 'Vital Sign not found'], 404);
        }
        return response()->json($vital);
    }
}