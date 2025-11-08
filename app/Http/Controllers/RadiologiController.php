<?php

namespace App\Http\Controllers;

use App\Models\Radiologi;
use App\Models\Sheep;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class RadiologiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $radiologis = Radiologi::all();
        return view('radiologi.index', compact('radiologis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $latestId = Radiologi::latest()->first()->id_riwayat_usg_domba ?? 0;

        $nextId = $latestId + 1;

        return view('radiologi.createRadiologi', compact('nextId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_domba' => 'required',
            'assesor' => 'required',
            'tanggal_assesmen' => 'required',
            'uploadGambar' => 'required',
        ]);
    
        if ($request->hasFile('uploadGambar')) {
            $image = $request->file('uploadGambar');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images/sheep/usg/'), $imageName);
        }
    
        // Simpan data ke database
        Radiologi::create([
            'id_domba' => $request->id_domba,
            'nama_assesor' => $request->assesor,
            'tanggal_assesmen' => $request->tanggal_assesmen,
            'gambar_usg' => 'images/sheep/usg/' . $imageName,
            'hasil' => $request->status,
            'keterangan_lain' => $request->keterangan
        ]);
    
        // Set flash session
        // session()->flash('success', 'Data berhasil disimpan!');
        
        // Debug session sebelum redirect
        // dd(session()->all()); // Cek apakah session tersimpan
        
        return redirect()->route('radiologi.create')->with('success', 'Data berhasil disimpan!');

    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_riwayat_usg_domba)
    {
        $radiologi = Radiologi::where('id_riwayat_usg_domba', $id_riwayat_usg_domba)->firstOrFail();
        $dombaList = Sheep::all(['id_domba', 'nama_domba']);
        $selectedDombaId = $radiologi->id_domba;        

        return view('radiologi.editRadiologi', compact('radiologi', 'dombaList', 'selectedDombaId'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_riwayat_usg_domba)
    {
        $request->validate([
            'id_domba' => 'required',
            'tanggal_assesmen' => 'required|date',
            'assesor' => 'required',
        ]);

        // Use `where` to find the record by `id_riwayat_usg_domba` and update fields
        $radiologi = Radiologi::where('id_riwayat_usg_domba', $id_riwayat_usg_domba)->firstOrFail();

        // Update the fields
        $radiologi->id_domba = $request->input('id_domba');
        $radiologi->tanggal_assesmen = $request->input('tanggal_assesmen');
        $radiologi->nama_assesor = $request->input('assesor');
        $radiologi->hasil = $request->input('status');
        $radiologi->keterangan_lain = $request->input('keterangan');

        // Handle file upload for image
        if ($request->hasFile('uploadGambar')) {
            if ($radiologi->gambar_usg && file_exists(public_path($radiologi->gambar_usg))) {
                unlink(public_path($radiologi->gambar_usg));
            }

            $image = $request->file('uploadGambar');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images/sheep/usg/'), $imageName);

            $radiologi->gambar_usg = 'images/sheep/usg/' . $imageName;
        }
        // dd($imageName);

        // Save changes
        $radiologi->save();

        return redirect()->route('radiologi.index')->with('success', 'Radiologi data updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bulkAction(Request $request)
    {
        $selected = $request->input('selected');
        $action = $request->input('action');
    
        if (empty($selected)) {
            return redirect()->route('radiologi.index')
                ->with('error', 'Silakan pilih setidaknya satu catatan.');
        }
    
        // Debugging
        // dd($action, $selected);
    
        if ($action == 'edit' && count($selected) == 1) {
            return redirect()->route('radiologi.edit', ['radiologi' => $selected[0]]);
        }
    
        if ($action == 'chart') {
            return redirect()->route('radiologi.riwayat', ['id' => $selected[0]]);
        }
    
        if ($action == 'delete') {
            Radiologi::whereIn('id_riwayat_usg_domba', $selected)->delete();
            return redirect()->route('radiologi.index')
                ->with('success', 'Catatan yang dipilih telah dihapus.');
        }
    
        return redirect()->route('radiologi.index')
            ->with('error', 'Tindakan tidak valid atau tidak ada tindakan yang dilakukan.');
    }
    
    

    public function riwayat($id)
    {
        $radio = Radiologi::findOrFail($id);
        
        $id_domba = $radio->id_domba;
        
        $radiologi = Radiologi::where('id_domba', $id_domba)->get();

        return view('radiologi.detailRadiologi', compact('radiologi', 'id_domba'));
    }
}
