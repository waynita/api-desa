<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected $key = 'email';
    protected $Users = [];

    public function __construct()
    {
        $this->Users = collect([
            [
                'name' => 'Root',
                'family_id' => null,
                'username' => 'root',
                'position_id' => 1,
                'show' => 0,
                'email' => 'root@main.com',
                'password' => Hash::make(env('LOGIN_ACCOUNT')),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Admin',
                'family_id' => null,
                'username' => 'admin',
                'position_id' => 2,
                'show' => 0,
                'email' => 'admin@main.com',
                'password' => Hash::make(env('LOGIN_ACCOUNT')),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'User Pertama',
                'family_id' => 1,
                'username' => 'user1',
                'position_id' => 4,
                'show' => 1,
                'email' => 'user1@main.com',
                'password' => Hash::make(env('LOGIN_ACCOUNT')),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'User Kedua',
                'family_id' => 1,
                'username' => 'user2',
                'position_id' => 4,
                'show' => 1,
                'email' => 'user2@main.com',
                'password' => Hash::make(env('LOGIN_ACCOUNT')),
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
        $Exists = DB::table('users')
            ->whereIn($this->key, $this->Users
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Users->diffKeys($Exists->toArray())->values();
        DB::table('users')->insert($New->all());

    }
}
