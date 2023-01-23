<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    protected $key = 'slug';
    protected $Menu = [];

    public function __construct()
    {
        $this->Menu = collect([
            [
                'id' => 1,
                'name' => 'Dashboard',
                'icon' => 'fas fa-home',
                'url' => '/',
                'slug' => 'dashboard',
                'parent_id' => null,
                'sorting' => 1,
                'file' => 'Modul.Dashboard',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'Kelola Data',
                'icon' => 'fas fa-clipboard',
                'url' => '#',
                'slug' => 'data',
                'parent_id' => null,
                'sorting' => 2,
                'file' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'name' => 'Data Penduduk',
                'icon' => 'fas fa-user',
                'url' => 'data_penduduk',
                'slug' => 'data_penduduk',
                'parent_id' => 2,
                'sorting' => 3,
                'file' => 'Modul.KelolaData.Penduduk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'name' => 'Data Keluarga',
                'icon' => 'fas fa-users',
                'url' => 'data_keluarga',
                'slug' => 'data_keluarga',
                'parent_id' => 2,
                'sorting' => 4,
                'file' => 'Modul.KelolaData.Keluarga',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'name' => 'Sirkulasi Penduduk',
                'icon' => 'fas fa-sync',
                'url' => '#',
                'slug' => 'sirkulasi_penduduk',
                'parent_id' => null,
                'sorting' => 5,
                'file' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 6,
                'name' => 'Data Lahir',
                'icon' => 'fas fa-baby',
                'url' => 'sirkulasi_data_lahir',
                'slug' => 'sirkulasi_data_lahir',
                'parent_id' => 5,
                'sorting' => 6,
                'file' => 'Modul.Sirkulasi.Kelahiran',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 7,
                'name' => 'Data Meninggal',
                'icon' => 'fas fa-book-dead',
                'url' => 'sirkulasi_meninggal',
                'slug' => 'sirkulasi_meninggal',
                'parent_id' => 5,
                'sorting' => 7,
                'file' => 'Modul.Sirkulasi.Kematian',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 8,
                'name' => 'Data Pendatang',
                'icon' => 'fas fa-plane-arrival',
                'url' => 'sirkulasi_pendatang',
                'slug' => 'sirkulasi_pendatang',
                'parent_id' => 5,
                'sorting' => 8,
                'file' => 'Modul.Sirkulasi.Pendatang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 9,
                'name' => 'Data Pindah',
                'icon' => 'fas fa-truck-moving',
                'url' => 'sirkulasi_pindah',
                'slug' => 'sirkulasi_pindah',
                'parent_id' => 5,
                'sorting' => 9,
                'file' => 'Modul.Sirkulasi.Pindah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 10,
                'name' => 'Kelola Surat',
                'icon' => 'fas fa-envelope',
                'url' => '#',
                'slug' => 'kelola_surat',
                'parent_id' => null,
                'sorting' => 10,
                'file' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 11,
                'name' => 'Surat Domisili',
                'icon' => 'fas fa-map-marker-alt',
                'url' => 'surat_domilisi',
                'slug' => 'surat_domilisi',
                'parent_id' => 10,
                'sorting' => 11,
                'file' => 'Modul.Surat.Domisili',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 12,
                'name' => 'Surat Kelahiran',
                'icon' => 'fas fa-baby-carriage',
                'url' => 'surat_kelahiran',
                'slug' => 'surat_kelahiran',
                'parent_id' => 10,
                'sorting' => 12,
                'file' => 'Modul.Surat.Kelahiran',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 13,
                'name' => 'Surat Kematian',
                'icon' => 'fas fa-book-dead',
                'url' => 'surat_kematian',
                'slug' => 'surat_kematian',
                'parent_id' => 10,
                'sorting' => 13,
                'file' => 'Modul.Surat.Kematian',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 14,
                'name' => 'Surat Pendatang',
                'icon' => 'fas fa-plane-arrival',
                'url' => 'surat_pendatang',
                'slug' => 'surat_pendatang',
                'parent_id' => 10,
                'sorting' => 14,
                'file' => 'Modul.Surat.Pendatang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 15,
                'name' => 'Surat Pindah',
                'icon' => 'fas fa-plane-departure',
                'url' => 'surat_pindah',
                'slug' => 'surat_pindah',
                'parent_id' => 10,
                'sorting' => 15,
                'file' => 'Modul.Surat.Pindah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 16,
                'name' => 'Laporan',
                'icon' => 'fas fa-file-pdf',
                'url' => '#',
                'slug' => 'laporan',
                'parent_id' => null,
                'sorting' => 16,
                'file' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 17,
                'name' => 'Data Penduduk',
                'icon' => 'fas fa-file-alt',
                'url' => 'laporan_penduduk',
                'slug' => 'laporan_penduduk',
                'parent_id' => 16,
                'sorting' => 17,
                'file' => 'Modul.Laporan.Penduduk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 18,
                'name' => 'Data Keluarga',
                'icon' => 'fas fa-file-invoice',
                'url' => 'laporan_keluarga',
                'slug' => 'laporan_keluarga',
                'parent_id' => 16,
                'sorting' => 18,
                'file' => 'Modul.Laporan.Keluarga',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 19,
                'name' => 'Data Lahir',
                'icon' => 'fas fa-file-medical-alt',
                'url' => 'laporan_lahir',
                'slug' => 'laporan_lahir',
                'parent_id' => 16,
                'sorting' => 19,
                'file' => 'Modul.Laporan.Kelahiran',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 20,
                'name' => 'Data Meninggal',
                'icon' => 'fas fa-file-medical',
                'url' => 'laporan_meninggal',
                'slug' => 'laporan_meninggal',
                'parent_id' => 16,
                'sorting' => 20,
                'file' => 'Modul.Laporan.Meninggal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 21,
                'name' => 'Data Pendatang',
                'icon' => 'fas fa-file-download',
                'url' => 'laporan_pendatang',
                'slug' => 'laporan_pendatang',
                'parent_id' => 16,
                'sorting' => 21,
                'file' => 'Modul.Laporan.Pendatang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 22,
                'name' => 'Data Pindah',
                'icon' => 'fas fa-file-upload',
                'url' => 'laporan_pindah',
                'slug' => 'laporan_pindah',
                'parent_id' => 16,
                'sorting' => 22,
                'file' => 'Modul.Laporan.Pindah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 23,
                'name' => 'Surat Pengantar',
                'icon' => 'fas fa-truck-moving',
                'url' => 'surat_pengantar',
                'slug' => 'surat_pengantar',
                'parent_id' => 10,
                'sorting' => 23,
                'file' => 'Modul.Surat.Pengantar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ])->keyBy($this->key);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Exists = DB::table('menu')
            ->whereIn($this->key, $this->Menu
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Menu->diffKeys($Exists->toArray())->values();
        DB::table('menu')->insert($New->all());
    }
}
