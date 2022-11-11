<?php

namespace Database\Seeders;

use App\Models\Announce;
use Illuminate\Database\Seeder;

class AnnouncesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Announce::factory()->count(100)->create();
        Announce::create([
            'shop_id' => '1',
            'announce_category_id' => '1',
            'start_date' => '2022/11/01 10:00:00',
            'end_date' => '2023/01/01 10:00:00',
            'title' => 'テストお知らせ',
            'thumbnail_img_path' => null,
            'contents' => 'お知らせの本文です。',
            'approval_status' => '2',
            'approval_account' => '1',
            'approval_datetime' => '2022/11/01 9:00:00',
            'remand_comment' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

    }
}
