<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PopulationSeeder extends Seeder
{
    protected $key = 'nik';
    protected $Users = [];

    public function __construct()
    {
        $this->Population = collect([
            [
                'user_id' => 3,
                'nik' => '1122334455',
                'place_of_birth' => 'Bekasi',
                'gender' => 'L',
                'village' => 'Bekasi Timur',
                'neighbourhood' => 1,
                'hamlet' => 5,
                'district' => 'Makasar',
                'religion' => 'Islam',
                'address' => 'Jalan Semangka',
                'married' => 'tidak',
                'relation' => 'Kepala Keluarga',
                'occupation' => 'Saudagar',
                'status' => 'ada',
                'created_at' => Carbon::now()
            ],
            [
                'user_id' => 4,
                'nik' => '1122335566',
                'place_of_birth' => 'Jambi',
                'gender' => 'L',
                'village' => 'Jambi Timur',
                'neighbourhood' => 1,
                'hamlet' => 5,
                'district' => 'Makasar',
                'religion' => 'Islam',
                'address' => 'Jalan Semangka',
                'married' => 'tidak',
                'relation' => 'istri',
                'occupation' => 'Pedagang',
                'status' => 'ada',
                'created_at' => Carbon::now()
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
        $Exists = DB::table('population')
            ->whereIn($this->key, $this->Population
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Population->diffKeys($Exists->toArray())->values();
        DB::table('population')->insert($New->all());

    }
}
