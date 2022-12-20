<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthoritySet;

class AuthoritySetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AuthoritySet::create([
            'id' => '1',
            'name' => '管理者',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'id' => '2',
            'name' => '投稿者',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'id' => '3',
            'name' => '閲覧者',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
    }
}
