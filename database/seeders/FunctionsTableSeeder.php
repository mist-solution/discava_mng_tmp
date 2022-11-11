<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Function;

class FunctionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Function::create([
            'name' => '投稿管理',
            'description' => 'お知らせを投稿する機能',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        Function::create([
            'name' => 'ギャラリー管理',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        Function::create([
            'name' => 'アクセス情報',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        Function::create([
            'name' => 'アカウント管理',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        Function::create([
            'name' => '契約情報',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        Function::create([
            'name' => 'サイト更新依頼',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        Function::create([
            'name' => 'WEBサイトへ',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
    }
}
