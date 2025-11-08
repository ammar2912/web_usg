<?php

use App\Http\Controllers\ApiImageController;
use App\Http\Controllers\tambah_penyakit;
use App\Http\Controllers\SheepController;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\View;
use App\Http\Controllers\Api\SheepAPIController;
use App\Http\Controllers\Api\AssesmenAPIController;
use App\Http\Controllers\api\VitalSignAPIController;
use App\Http\Controllers\RadiologiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VitalSignController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Semua rute di dalam grup ini hanya bisa diakses oleh pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
  	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/vital-sign/chart/{id}', [VitalSignController::class, 'chart'])->name('vital-sign.chart');
    Route::get('/radiologi/riwayat/{id}', [RadiologiController::class, 'riwayat'])->name('radiologi.riwayat');

    Route::get('/create-Radiologi', function () {
        return view('createRadiologi');
    })->name('Radiologi.create');

    Route::resource('sheep', SheepController::class);

    Route::get('/list-penyakit', [tambah_penyakit::class,'index_penyakit'])->name('index_penyakit');

    Route::prefix('/list-penyakit')->group(function(){
        Route::get('/form-tambah', [tambah_penyakit::class, 'form_tambah'])->name('form_tambah');
        Route::post('/form-tambah/simpan',[tambah_penyakit::class,'simpan'])->name('simpan_data');
        Route::post('/hapus-data', [tambah_penyakit::class, 'delete'])->name('hapus_data');
        Route::get('/form-edit/{id}', [tambah_penyakit::class, 'form_edit'])->name('form_edit');
        Route::post('/form-edit/{id}/edit',[tambah_penyakit::class,'update'])->name('edit_data');
    });

    Route::get('/domba/select', [SheepController::class, 'getSheepList']);
    Route::get('/domba/data/{dombaId}', [SheepController::class, 'getData']);
    Route::get('/domba/dataRadiologi/{dombaId}', [SheepController::class, 'getDataRadiologi']);

    Route::post('/upload-image', [ApiImageController::class, 'upload']);

    Route::get('/sheep-api', [SheepAPIController::class, 'index']);
    Route::get('/sheep-api/{id}', [SheepAPIController::class, 'show']);

    Route::get('/assesmen-api', [AssesmenAPIController::class, 'index']);
    Route::get('/assesmen-api/{id}', [AssesmenAPIController::class, 'show']);

    Route::get('/vitalSign-api', [VitalSignAPIController::class, 'index']);
    Route::get('/vitalSign-api/{id}', [VitalSignAPIController::class, 'show']);

    Route::resource('/user', UserController::class);
    Route::post('user/bulk-action', [UserController::class, 'bulkAction'])->name('user.bulkAction');

    Route::get('/generate-user-code', 'UserController@generateUserCode');
    Route::get('/detail-sheep/{id}', [SheepController::class, 'generateQrCode'])->name('sheep.qrcode');

    Route::resource('/radiologi', RadiologiController::class);
    Route::post('radiologi/bulk-action', [RadiologiController::class, 'bulkAction'])->name('radiologi.bulkAction');

    Route::resource('/vital-sign', VitalSignController::class);
    Route::post('vital-sign/bulk-action', [VitalSignController::class, 'bulkAction'])->name('vital-sign.bulkAction');

    Route::post('/predict', function (Request $request) {
        $request->validate([
            'uploadGambar' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $image = $request->file('uploadGambar');

        $response = Http::attach(
            'file',
            file_get_contents($image->getPathname()),
            $image->getClientOriginalName()
        )->post('http://127.0.0.1:5000/predict');

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Gagal melakukan prediksi'], 500);
        }
    });
});