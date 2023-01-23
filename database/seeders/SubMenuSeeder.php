<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SubMenuSeeder extends Seeder
{
    protected $key = 'name';
    protected $SubMenu = [];

    public function __construct()
    {
        $this->SubMenu = collect([
            [
                'name' => 'detail',
                'parameter' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'insert',
                'parameter' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'update',
                'parameter' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'print',
                'parameter' => 1,
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
        $Exists = DB::table('submenu')
            ->whereIn($this->key, $this->SubMenu
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->SubMenu->diffKeys($Exists->toArray())->values();
        DB::table('submenu')->insert($New->all());

    }
}
