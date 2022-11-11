<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MateFunction;

class MateFunctionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MateFunction::create([
            'name' => '投稿管理',
            'description' => 'お知らせを投稿する機能',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        MateFunction::create([
            'name' => 'ギャラリー管理',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        MateFunction::create([
            'name' => 'アクセス情報',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        MateFunction::create([
            'name' => 'アカウント管理',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        MateFunction::create([
            'name' => '契約情報',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        MateFunction::create([
            'name' => 'サイト更新依頼',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        MateFunction::create([
            'name' => 'WEBサイトへ',
            'description' => '',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
    }
}
