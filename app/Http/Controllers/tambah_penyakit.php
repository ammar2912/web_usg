<?php

namespace App\Http\Controllers;

use App\Models\assesmen;
use App\Models\Sheep;
use Illuminate\Http\Request;

class tambah_penyakit extends Controller
{
    public function index_penyakit(){
        $data = assesmen::all();
        // dd($data);
        return view('penyakit.index-penyakit',['data'=>$data]);
    }
    public function form_tambah(){
      	$dombas = Sheep::all();
        return view('penyakit.tambah-penyakit', compact('dombas'));
    }

    public function simpan(Request $request){
        // dd($request);

            $validate = $request->validate([
            "id_assesmen" => 'required',
            "id_domba" => 'required',
            "tanggal_assesmen" => 'required',
            "usia_domba" => 'required',
            "assesor" => 'required',
            "gejala1" => 'required',
            "gejala2" => 'required',
            "gejala3" => 'required',
            "gejala4" => 'required',
            "gejala5" => 'required',
            "gejala6" => 'sometimes|nullable',
            "gejala7" => 'sometimes|nullable',
            "gejala8" => 'sometimes|nullable',
            "keterangan" => 'sometimes|nullable'
        ]);

        $post = Assesmen::create([
            "ID_ASSESMEN" => $request->input('id_assesmen'),
            "ID_DOMBA" => $request->input('id_domba'),
            "NAMA_ASSESOR" => $request->input('assesor'),
            "TANGGAL_ASSESMEN" => $request->input('tanggal_assesmen'),
            "USIA_DOMBA" => $request->input('usia_domba'),
            "GEJALA_1" => $request->input('gejala1'),
            "GEJALA_2" => $request->input('gejala2'),
            "GEJALA_3" => $request->input('gejala3'),
            "GEJALA_4" => $request->input('gejala4'),
            "GEJALA_5" => $request->input('gejala5'),
            "GEJALA_6" => $request->input('gejala6'),
            "GEJALA_7" => $request->input('gejala7'),
            "GEJALA_8" => $request->input('gejala8'),
            "KETERANGAN" => $request->input('keterangan')
        ]);

        return redirect()->route('index_penyakit')->with('success', 'Data berhasil disimpan');
    }
    public function delete(Request $request)
    {

        $ids = $request->input('selectedItems');

        // Periksa apakah $ids tidak kosong sebelum menghapus
        if (!empty($ids)) {
            assesmen::whereIn('ID_ASSESMEN', $ids)->delete();
            return redirect()->route('index_penyakit')->with('success', 'Data yang dipilih berhasil dihapus.');
        } else {
            // Jika tidak ada checkbox yang dipilih, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Pilih setidaknya satu item untuk dihapus.');
        }
    }
    public function form_edit($id)
    {
        // dd($id);
        $data = assesmen::where('ID_ASSESMEN', $id)->first();
        return view('penyakit.edit-penyakit', compact('data'));
    }
    public function update(Request $request, $id){
        $data = assesmen::where('ID_ASSESMEN', $id)->first();
        $data->GEJALA_1 = $request->gejala1;
        $data->GEJALA_2 = $request->gejala2;
        $data->GEJALA_3 = $request->gejala3;
        $data->GEJALA_4 = $request->gejala4;
        $data->GEJALA_5 = $request->gejala5;
        $data->GEJALA_6 = $request->gejala6;
        $data->GEJALA_7 = $request->gejala7;
        $data->GEJALA_8 = $request->gejala8;
        $data->save();
        return redirect()->route('index_penyakit')->with('success', 'Data berhasil diupdate');
    }
}
