<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('id', 'asc')->get();
        return view('user.index-user', compact('user'));
    }

    public function create()
    {
        return view('user.create-user');
    }

    public function store(Request $request)
    {

        $validate = $request->validate([]);

        $post = User::create([
            "name" => $request->input('nama'),
            // "role" => $request->input('role'),
            "email" => $request->input('email'),
            "password" => Hash::make($request->input('password')),
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil disimpan');
    }

    public function delete(Request $request)
    {

        $ids = $request->input('selectedItems');

        // Periksa apakah $ids tidak kosong sebelum menghapus
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return redirect()->route('index_penyakit')->with('success', 'Data yang dipilih berhasil dihapus.');
        } else {
            // Jika tidak ada checkbox yang dipilih, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Pilih setidaknya satu item untuk dihapus.');
        }
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('user.edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:6', // Password opsional
    ]);

    // Cari user berdasarkan ID
    $user = User::findOrFail($id);

    // Update data user
    $user->name = $request->nama;
    $user->email = $request->email;

    // Update password jika diisi dan berbeda dari yang lama
    if ($request->filled('password') && !Hash::check($request->password, $user->password)) {
    $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('user.index')->with('success', 'Data berhasil diperbarui.');
    }
    

    public function bulkAction(Request $request)
    {
        $selected = $request->input('selected', []);
        $action = $request->input('action');
    
        if (empty($selected)) {
            return redirect()->route('user.index')
                ->with('error', 'Silakan pilih setidaknya satu catatan.');
        }
    
        if ($action == 'edit' && count($selected) == 1) {
            return redirect()->route('user.edit', ['user' => $selected[0]]);
        }
    
        if ($action == 'delete') {
            User::whereIn('id', $selected)->delete();
            return redirect()->route('user.index')
                ->with('success', 'Catatan yang dipilih telah dihapus.');
        }
    
        return redirect()->route('user.index')
            ->with('error', 'Tindakan tidak valid atau tidak ada tindakan yang dilakukan.');
    }
    

    
}
