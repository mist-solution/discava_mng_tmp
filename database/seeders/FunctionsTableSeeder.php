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
        ]);
        Function::create([
            'name' => 'ギャラリー管理',
            'description' => '',
        ]);
        Function::create([
            'name' => 'アクセス情報',
            'description' => '',
        ]);
        Function::create([
            'name' => 'アカウント管理',
            'description' => '',
        ]);
        Function::create([
            'name' => '契約情報',
            'description' => '',
        ]);
        Function::create([
            'name' => 'サイト更新依頼',
            'description' => '',
        ]);
        Function::create([
            'name' => 'WEBサイトへ',
            'description' => '',
        ]);
    }
}
