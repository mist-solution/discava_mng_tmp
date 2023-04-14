<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediaFolder;

class MediaFoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MediaFolder::create([
            'id' => '1',
            'shop_id' => '1',
            'parent_folder_id' => '0',
            'name' => '未分類',
            'media_sort' => '2',
            'media_width' => '512',
            'media_height' => '216',
            'media_column_num' => '1',
            'media_align' => '1',
            'media_link' => '0',
            'media_link_url' => '',
            'media_margin' => '0',
            'media_caption' => '0',
            'media_frame_design' => '0',
            'media_shadow' => '0',
            'media_hover_expand' => '0',
            'media_hover_icon' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '1',
            'kaisou' => '1',
        ]);
    }
}
