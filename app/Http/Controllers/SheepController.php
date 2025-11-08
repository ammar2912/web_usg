<?php

namespace App\Http\Controllers;

use App\Models\Radiologi;
use App\Models\Sheep;
use App\Models\VitalSign;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Exception\GenerateImageException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SheepController extends Controller
{
    public function index()
    {
        $sheep = Sheep::orderBy('id', 'desc')->paginate(10);
        
        return view('sheep.readSheep', compact('sheep'));
    }
    
    public function create()
    {
        $lastSheep = Sheep::orderByRaw('RIGHT(id_domba, 4) DESC')->first();

        if ($lastSheep) {
            $lastId = intval(substr($lastSheep->id_domba, -4));
            $newIdDombaSuffix = str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newIdDombaSuffix = '0001';
        }

        return view('sheep.createSheep', compact('newIdDombaSuffix'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_domba_first' => 'required',
            'namaDomba' => 'required',
            'bobot' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $prefix = $request->input('id_domba_first');
        $newIdDombaSuffix = $request->input('id_domba_last');
        $newIdDomba = $prefix . $newIdDombaSuffix;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images/sheep/foto/'), $imageName);
        }

        $qrCodeResult = Builder::create()
            ->writer(new PngWriter())
            ->data($newIdDomba)
            ->size(200)
            ->build();

        $qrCodePath = 'images/sheep/qrcodes/' . $newIdDomba . '.png';

        $qrCodeResult->saveToFile(public_path($qrCodePath));

        Sheep::create([
            'id_domba' => $newIdDomba,
            'nama_domba' => $request->input('namaDomba'),
            'id_induk_jantan' => $request->input('idIndukJantan'),
            'id_induk_betina' => $request->input('idIndukBetina'),
            'bobot' => $request->input('bobot'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'image' => 'images/sheep/foto/' . $imageName,
            'qr_code' => $qrCodePath,
        ]);

        return redirect()->route('sheep.index')
            ->with('success', 'Data Domba Berhasil di Tambah.');
    }

    public function show(Sheep $sheep)
    {
        return view('sheep.readSheep', compact('sheep'));
    }

    public function edit(Sheep $sheep)
    {
        return view('sheep.editSheep', compact('sheep'));
    }

    public function update(Request $request, Sheep $sheep)
    {
        $id_domba=$request->input('id_domba');
        $request->validate([
            'id_domba' => 'required',
            'namaDomba' => 'required',
            'bobot' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            if ($sheep->image && file_exists(public_path($sheep->image))) {
                unlink(public_path($sheep->image));
            }

            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images/sheep/foto/'), $imageName);

            $sheep->image = 'images/sheep/foto/' . $imageName;
        }

        if ($id_domba) {

            if ($sheep->qr_code && file_exists(public_path($sheep->qr_code))) {
                unlink(public_path($sheep->qr_code));
            }

            $qrCodeResult = Builder::create()
                ->writer(new PngWriter())
                ->data($id_domba)
                ->size(200)
                ->build();

            $qrCodePath = 'images/sheep/qrcodes/' . $id_domba . '.png';
            $qrCodeResult->saveToFile(public_path($qrCodePath));

            $sheep->id_domba = $id_domba;
            $sheep->qr_code = $qrCodePath;
        }

        if ($sheep->qr_code == null) {

            $qrCodeResult = Builder::create()
                ->writer(new PngWriter())
                ->data($id_domba)
                ->size(200)
                ->build();

            $qrCodePath = 'images/sheep/qrcodes/' . $id_domba . '.png';

            $qrCodeResult->saveToFile(public_path($qrCodePath));

            $sheep->qr_code = $qrCodePath;
        }


        $sheep->nama_domba = $request->input('namaDomba');
        $sheep->id_induk_jantan = $request->input('idIndukJantan');
        $sheep->id_induk_betina = $request->input('idIndukBetina');
        $sheep->bobot = $request->input('bobot');
        $sheep->tanggal_lahir = $request->input('tanggal_lahir');

        $sheep->save();

        return redirect()->route('sheep.index')
            ->with('success', 'Data Domba Berhasil di Ubah');
    }

    public function destroy(Sheep $sheep)
    {
        $sheep->delete();
        // dd($sheep);
        return redirect()->route('sheep.index')
            ->with('success', 'Data Domba Berhasil di Hapus');
    }

    public function generateQrCode($id_domba)
    {
        $result = DB::table('vital_signs')
        ->join('sheep', 'vital_signs.id_domba', '=', 'sheep.id_domba')
        ->where('vital_signs.id_domba', $id_domba)
        ->orderByDesc('vital_signs.id')
        ->limit(1)
        ->select('vital_signs.id')
        ->first();

        $hasil = DB::table('riwayat_usg_domba')
        ->join('sheep', 'riwayat_usg_domba.id_domba', '=', 'riwayat_usg_domba.id_domba')
        ->where('riwayat_usg_domba.id_domba', $id_domba)
        ->orderByDesc('riwayat_usg_domba.id_riwayat_usg_domba')
        ->limit(1)
        ->select('riwayat_usg_domba.id_riwayat_usg_domba')
        ->first();


        try {
            $sheep = Sheep::where('id_domba', $id_domba)->first();
            if (!$sheep) {
                return response('Sheep not found', 404);
            }

            $qrCode = Builder::create()
                ->writer(new PngWriter())
                ->data($id_domba)
                ->build();

            return view('sheep.detailSheep', [
                'qrCode' => $qrCode->getString(),
                'sheep' => $sheep,
                'result' => $result,
                'hasil' => $hasil,
            ]);
        } catch (GenerateImageException $e) {
            return response('Unable to generate image: ' . $e->getMessage(), 500);
        }
    }

    public function getSheepList()
    {
        $dombaList = Sheep::all(['id_domba', 'nama_domba']);

        return response()->json($dombaList);
    }

    public function getData($dombaId)
    {
        $data = VitalSign::where('id_domba', $dombaId)
                        ->orderBy('created_at', 'asc')
                        ->take(3)
                        ->get(['detak_jantung', 'tekanan_darah', 'berat', 'suhu', 'pernafasan', 'mata', 'kuku', 'kondisi', 'created_at'])
                        ->map(function ($item) {
                            $item->kondisi = $item->kondisi;
                            $item->mata = $item->mata;
                            $item->kuku = $item->kuku;
                            return $item;
                        });

    return response()->json($data);
    }

    public function getDataRadiologi($dombaId)
    {
        $data = Radiologi::where('id_domba', $dombaId)
                        ->orderBy('created_at', 'asc')
                        ->take(3)
                        ->get(['gambar_usg', 'hasil', 'created_at'])
                        ->map(function ($item) {
                            $item->gambar_usg = asset($item->gambar_usg);
                            $item->hasil = $item->hasil;
                            return $item;
                        });

    return response()->json($data);
    }

}
