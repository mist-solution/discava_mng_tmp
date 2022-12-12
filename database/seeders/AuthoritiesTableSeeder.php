<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Authority;

class AuthoritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Authority::create([
            'id' => '1',
            'name' => '管理',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        Authority::create([
            'id' => '2',
            'name' => '一般',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        Authority::create([
            'id' => '3',
            'name' => '閲覧',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
    }
}
