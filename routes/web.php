<?php

use App\Http\Controllers\Link\LinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Born\BornBrowseController;
use App\Http\Controllers\Comer\ComerBrowseController;
use App\Http\Controllers\Dead\DeadBrowseController;
use App\Http\Controllers\Family\FamilyBrowseController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Move\MoveBrowseController;
use App\Http\Controllers\Position\PositionBrowseController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\User\UserBrowseController;
use App\Http\Controllers\User\UserController;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('login', function () {
    return view("Modul.Login.Login");
})->name('login');

Route::post('login', [LoginController::class, 'Anything']);

Route::middleware('auth')->group(function () {
    Route::post("get_born", [BornBrowseController::class,"Anything"])->name('GetBorn');
    Route::post("get_comer", [ComerBrowseController::class,"Anything"])->name('GetComer');
    Route::post("get_dead", [DeadBrowseController::class,"Anything"])->name('GetDead');
    Route::post("get_family", [FamilyBrowseController::class,"Anything"])->name('GetFamily');
    Route::post("get_move", [MoveBrowseController::class,"Anything"])->name('GetMove');
    Route::post("get_position", [PositionBrowseController::class,"Anything"]);
    Route::post("get_user", [UserBrowseController::class,"Anything"])->name('GetUser');

    Route::post("user/insert", [UserController::class,"Insert"])->name('UserInsert');

    Route::get("/", function() { return view("Modul.Dashboard"); });

    // Data
    Route::get("/data_penduduk", function() { return view("Modul.KelolaData.Penduduk"); });
    Route::get("/data_keluarga", function() { return view("Modul.KelolaData.Keluarga"); });

    Route::get("/sirkulasi_data_lahir", function() { return view("Modul.Sirkulasi.Kelahiran"); });
    Route::get("/sirkulasi_meninggal", function() { return view("Modul.Sirkulasi.Kematian"); });
    Route::get("/sirkulasi_pendatang", function() { return view("Modul.Sirkulasi.Pendatang"); });
    Route::get("/sirkulasi_pindah", function() { return view("Modul.Sirkulasi.Pindah"); });

    Route::get("/surat_domilisi", function() { return view("Modul.Surat.Domisili"); });
    Route::get("/surat_kelahiran", function() { return view("Modul.Surat.Kelahiran"); });
    Route::get("/surat_kematian", function() { return view("Modul.Surat.Kematian"); });
    Route::get("/surat_pendatang", function() { return view("Modul.Surat.Pendatang"); });
    Route::get("/surat_pindah", function() { return view("Modul.Surat.Pindah"); });

    Route::get("/laporan_penduduk", function() { 
        $From = Carbon::now()->toDateString();
        $End = Carbon::now()->endOfMonth()->toDateString(); 
        return view("Modul.Laporan.Penduduk")->with(compact('From', 'End')); 
    });

    Route::get("/laporan_keluarga", function() { 
        $From = Carbon::now()->toDateString();
        $End = Carbon::now()->endOfMonth()->toDateString(); 
        return view("Modul.Laporan.Keluarga")->with(compact('From', 'End')); 
    });

    Route::get("/laporan_lahir", function() { 
        $From = Carbon::now()->toDateString();
        $End = Carbon::now()->endOfMonth()->toDateString(); 
        return view("Modul.Laporan.Kelahiran")->with(compact('From', 'End')); 
    });

    Route::get("/laporan_meninggal", function() { 
        $From = Carbon::now()->toDateString();
        $End = Carbon::now()->endOfMonth()->toDateString(); 
        return view("Modul.Laporan.Meninggal")->with(compact('From', 'End')); 
    });

    Route::get("/laporan_pendatang", function() { 
        $From = Carbon::now()->toDateString();
        $End = Carbon::now()->endOfMonth()->toDateString(); 
        return view("Modul.Laporan.Pendatang")->with(compact('From', 'End')); 
    });

    Route::get("/laporan_pindah", function() { 
        $From = Carbon::now()->toDateString();
        $End = Carbon::now()->endOfMonth()->toDateString(); 
        return view("Modul.Laporan.Pindah")->with(compact('From', 'End')); 
    });

    Route::get("/surat_pengantar", function() { return view("Modul.Surat.Pengantar"); });
    // end Data

    // Insert
    Route::get("/data_penduduk/insert", function() { return view("Modul.KelolaData.Penduduk.Insert"); });
    Route::get("/data_keluarga/insert", function() { return view("Modul.KelolaData.Keluarga.Insert"); });

    Route::get("/sirkulasi_data_lahir/insert", function() { return view("Modul.Sirkulasi.Kelahiran.Insert"); });
    Route::get("/sirkulasi_meninggal/insert", function() { return view("Modul.Sirkulasi.Kematian.Insert"); });
    Route::get("/sirkulasi_pendatang/insert", function() { return view("Modul.Sirkulasi.Pendatang.Insert"); });
    Route::get("/sirkulasi_pindah/insert", function() { return view("Modul.Sirkulasi.Pindah.Insert"); });

    Route::get("/surat_domilisi/insert", function() { return view("Modul.Surat.Domisili.Insert"); });
    Route::get("/surat_kelahiran/insert", function() { return view("Modul.Surat.Kelahiran.Insert"); });
    Route::get("/surat_kematian/insert", function() { return view("Modul.Surat.Kematian.Insert"); });
    Route::get("/surat_pendatang/insert", function() { return view("Modul.Surat.Pendatang.Insert"); });
    Route::get("/surat_pindah/insert", function() { return view("Modul.Surat.Pindah.Insert"); });

    Route::get("/laporan_penduduk/insert", function() { return view("Modul.Laporan.Penduduk.Insert"); });
    Route::get("/laporan_keluarga/insert", function() { return view("Modul.Laporan.Keluarga.Insert"); });
    Route::get("/laporan_lahir/insert", function() { return view("Modul.Laporan.Kelahiran.Insert"); });
    Route::get("/laporan_meninggal/insert", function() { return view("Modul.Laporan.Meninggal.Insert"); });
    Route::get("/laporan_pendatang/insert", function() { return view("Modul.Laporan.Pendatang.Insert"); });
    Route::get("/laporan_pindah/insert", function() { return view("Modul.Laporan.Pindah.Insert"); });
    Route::get("/surat_pengantar/insert", function() { return view("Modul.Surat.Pengantar.Insert"); });
    // end Insert
    
    Route::post("/getUser", [UserBrowseController::class, "getUser"])->name("getUser");
    Route::post("/getFamily", [FamilyBrowseController::class, "getFamily"])->name("getFamily");

    Route::get("/data_keluarga/detail/{id}", [FamilyBrowseController::class, "Details"]);

    // Update
    Route::get("/data_penduduk/update/{id}", [UserBrowseController::class, "Update"]);
    Route::get("/data_keluarga/update/{id}", [FamilyBrowseController::class, "Update"]);
    // end Update

    // Download
    Route::post("download/{uuid}", [ReportController::class, "anything"])->name("download");
    // Download
});