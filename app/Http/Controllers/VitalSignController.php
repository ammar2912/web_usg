<?php

namespace App\Http\Controllers;

use App\Models\Sheep;
use App\Models\VitalSign;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class VitalSignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vitalsigns = VitalSign::all();
        return view('vitalsign.vital', compact('vitalsigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vitalsign.tambahvital');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'id_domba' => 'required|string',
        //     'tanggal' => 'required|date',
        //     'asesor' => 'required|string|max:255',
        //     'detak' => 'required',
        //     'tekanan' => 'required',
        //     'kondisi' => 'required',
        //     'suhu' => 'required',
        //     'berat' => 'required',
        //     'pernafasan' => 'required',
        //     'mata' => 'required',
        //     'kuku' => 'required',
        // ]);

        // Simpan data ke database
        $data = VitalSign::create([
            'id_domba' => $request->id_domba,
            'tanggal' => $request->tanggal_lahir,
            'asesor' => $request->asesor,
            'detak_jantung' => $request->detak,
            'tekanan_darah' => $request->tekanan,
            'kondisi' => $request->kondisi,
            'suhu' => $request->suhu,
            'berat' => $request->berat,
            'pernafasan' => $request->pernafasan,
            'mata' => $request->mata,
            'kuku' => $request->kuku,
            'lainnya' => $request->lainnya,
            
        ]);        

        // Redirect atau kembali ke halaman sebelumnya dengan notifikasi
        return redirect()->route('vital-sign.index')->with('success', 'Data berhasil disimpan!');
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
    public function edit(string $id)
    {
        $vitalSign = VitalSign::findOrFail($id);
        $dombaList = Sheep::all(['id_domba', 'nama_domba']);
        $selectedDombaId = $vitalSign->id_domba;

        return view('vitalsign.editvital', compact('vitalSign', 'dombaList', 'selectedDombaId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_domba' => 'required|string',
            'tanggal' => 'required|date',
            'asesor' => 'required|string|max:255',
            'detak' => 'required',
            'tekanan' => 'required',
            'kondisi' => 'required',
            'suhu' => 'required',
            'berat' => 'required',
            'pernafasan' => 'required',
            'mata' => 'required',
            'kuku' => 'required',
        ]);

        // Temukan data yang akan diupdate
        $vitalSign = VitalSign::findOrFail($id);

        // Update data
        $vitalSign->update([
            'id_domba' => $request->id_domba,
            'tanggal' => $request->tanggal_lahir,
            'asesor' => $request->asesor,
            'detak_jantung' => $request->detak,
            'tekanan_darah' => $request->tekanan,
            'kondisi' => $request->kondisi,
            'suhu' => $request->suhu,
            'berat' => $request->berat,
            'pernafasan' => $request->pernafasan,
            'mata' => $request->mata,
            'kuku' => $request->kuku,
            'lainnya' => $request->lainnya,
        ]);

        // Redirect atau kembali ke halaman sebelumnya dengan notifikasi
        return redirect()->route('vital-sign.index')->with('success', 'Data berhasil diperbarui!');
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
            return redirect()->route('vital-sign.index')
                ->with('error', 'Silakan pilih setidaknya satu catatan.');
        }

        if ($action == 'edit' && count($selected) == 1) {
            return redirect()->route('vital-sign.edit', ['vital_sign' => $selected[0]]);
        }

        if ($action == 'chart') {
            // If at least one domba is selected, we redirect to the chart page
            return redirect()->route('vital-sign.chart', ['id' => $selected[0]]);
        }

        if ($action == 'delete') {
            VitalSign::whereIn('id', $selected)->delete();
            return redirect()->route('vital-sign.index')
                ->with('success', 'Catatan yang dipilih telah dihapus.');
        }

        return redirect()->route('vital-sign.index')
            ->with('error', 'Tindakan tidak valid atau tidak ada tindakan yang dilakukan.');
    }

    public function chart($id)
    {
        // Ambil data vital sign berdasarkan ID vital sign
        $vitalSign = VitalSign::findOrFail($id);

        // Ambil id_domba dari data vital sign yang ditemukan
        $id_domba = $vitalSign->id_domba;

        // Ambil semua data vital sign berdasarkan id_domba
        $vitalsigns = VitalSign::where('id_domba', $id_domba)->get();

        // Kirimkan id_domba dan vitalsigns ke view
        return view('vitalsign.chartvital', compact('vitalsigns', 'id_domba'));
    }
}
