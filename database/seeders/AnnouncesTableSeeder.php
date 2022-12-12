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

        for($i = 1; $i < 10; $i++) {

            // Announce::factory()->count(100)->create();
            Announce::create([
                'shop_id' => '1',
                'announce_category_id' => '1',
                'start_date' => '2022/11/01 10:00:00',
                'end_date' => '2023/01/02 11:00:00',
                'title' => 'テストお知らせ1',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '0',
                'approval_account' => null,
                'approval_datetime' => null,
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

            Announce::create([
                'shop_id' => '1',
                'announce_category_id' => '2',
                'start_date' => '2022/11/02 10:00:00',
                'end_date' => '2023/01/03 11:00:00',
                'title' => 'テストお知らせ2',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '1',
                'approval_account' => null,
                'approval_datetime' => null,
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

            Announce::create([
                'shop_id' => '1',
                'announce_category_id' => '2',
                'start_date' => '2022/11/02 10:00:00',
                'end_date' => '2023/01/03 11:00:00',
                'title' => 'テストお知らせ3',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '1',
                'approval_account' => null,
                'approval_datetime' => null,
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

            Announce::create([
                'shop_id' => '1',
                'announce_category_id' => '2',
                'start_date' => '2022/11/02 10:00:00',
                'end_date' => '2023/01/03 11:00:00',
                'title' => 'テストお知らせ4',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '1',
                'approval_account' => null,
                'approval_datetime' => null,
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

            Announce::create([
                'shop_id' => '1',
                'announce_category_id' => '2',
                'start_date' => '2022/11/02 10:00:00',
                'end_date' => '2023/01/03 11:00:00',
                'title' => 'テストお知らせ5',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '2',
                'approval_account' => '1',
                'approval_datetime' => '2022/11/01 9:00:00',
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

            Announce::create([
                'shop_id' => '1',
                'announce_category_id' => '2',
                'start_date' => '2022/11/02 10:00:00',
                'end_date' => '2023/01/03 11:00:00',
                'title' => 'テストお知らせ6',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '2',
                'approval_account' => '1',
                'approval_datetime' => '2022/11/01 9:00:00',
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

            Announce::create([
                'shop_id' => '1',
                'announce_category_id' => '2',
                'start_date' => '2022/11/02 10:00:00',
                'end_date' => '2023/01/03 11:00:00',
                'title' => 'テストお知らせ7',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '3',
                'approval_account' => null,
                'approval_datetime' => null,
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

            Announce::create([
                'shop_id' => '1',
                'announce_category_id' => '2',
                'start_date' => '2022/11/02 10:00:00',
                'end_date' => '2023/01/03 11:00:00',
                'title' => 'テストお知らせ8',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '3',
                'approval_account' => null,
                'approval_datetime' => null,
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

            Announce::create([
                'shop_id' => '2',
                'announce_category_id' => '1',
                'start_date' => '2022/12/02 10:00:00',
                'end_date' => '2023/01/03 11:00:00',
                'title' => 'テストお知らせ（高松）',
                'thumbnail_img_path' => null,
                'contents' => 'お知らせの本文です。',
                'approval_status' => '3',
                'approval_account' => null,
                'approval_datetime' => null,
                'remand_comment' => null,
                'add_account' => $i,
                'upd_account' => '1',
                'del_flg' => '0',
            ]);

        }
    }
}
