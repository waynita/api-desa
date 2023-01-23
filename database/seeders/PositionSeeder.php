<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    protected $key = 'name';
    protected $Position = [];

    public function __construct()
    {
        $this->Position = collect([
            [
                'name' => 'Superadmin',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Admin',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Superuser',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'User',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Smalluser',
                'updated_at' => Carbon::now(),
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
        $Exists = DB::table('positions')
            ->whereIn($this->key, $this->Position
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Position->diffKeys($Exists->toArray())->values();
        DB::table('positions')->insert($New->all());

    }
}
