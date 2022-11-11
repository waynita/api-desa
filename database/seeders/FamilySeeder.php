<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    protected $key = 'number_family';
    protected $Users = [];

    public function __construct()
    {
        $this->Family = collect([
            [
                'number_family' => '119988877',
                'head_id' => 3,
                'village' => "Bekasi Timur",
                'neighbourhood' => 1,
                'hamlet' => 2,
                'sub_districts' => "Bekasi Barat",
                'districts' => "Bekasi",
                'province' => "Bekasi"
            ],
        ])->keyBy($this->key);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Exists = DB::table('family')
            ->whereIn($this->key, $this->Family
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Family->diffKeys($Exists->toArray())->values();
        DB::table('family')->insert($New->all());

    }
}
