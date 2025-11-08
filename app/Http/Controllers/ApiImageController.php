<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ApiImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validasi file
        $validatedData = $request->validate([
            'filename' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil file gambar dari request
        $fotoimg = $request->file('filename');

        // Dapatkan nama asli file
        $originalName = $fotoimg->getClientOriginalName();

        // Pindahkan file ke direktori 'images' di public path
        $fotoimgpath = $fotoimg->storeAs('image', $originalName, 'public');

        // Simpan informasi file ke database
        $image = Image::create([
            'filename' => $originalName
        ]);

        // Kembalikan respon JSON
        return response()->json(['message' => 'Image uploaded successfully', 'image' => $image], 200);
    }

}
