<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnounceCategory;

class AnnounceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnnounceCategory::create([
            'shop_id' => '1',
            'category_name' => 'お知らせ',
            'description' => null,
            'icon' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AnnounceCategory::create([
            'shop_id' => '1',
            'category_name' => '重要なお知らせ',
            'description' => null,
            'icon' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AnnounceCategory::create([
            'shop_id' => '1',
            'category_name' => 'イベント',
            'description' => null,
            'icon' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        AnnounceCategory::create([
            'shop_id' => '2',
            'category_name' => 'お知らせ',
            'description' => null,
            'icon' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AnnounceCategory::create([
            'shop_id' => '2',
            'category_name' => 'お得情報',
            'description' => null,
            'icon' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

    }
}
