<?php

namespace Database\Seeders;

use App\Models\AnnounceAttachment;
use Illuminate\Database\Seeder;

class AnnounceAttachmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        AnnounceAttachment::create([
            'shop_id' => '1',
            'announce_id' => '1',
            'img_path' => '/announce/1/1/attachments/',
            'img_filename' => 'sample1.png',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        AnnounceAttachment::create([
            'shop_id' => '1',
            'announce_id' => '1',
            'img_path' => '/announce/1/1/attachments/',
            'img_filename' => 'sample2.png',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        AnnounceAttachment::create([
            'shop_id' => '1',
            'announce_id' => '1',
            'img_path' => '/announce/1/1/attachments/',
            'img_filename' => 'sample3.png',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        AnnounceAttachment::create([
            'shop_id' => '1',
            'announce_id' => '2',
            'img_path' => '/announce/1/2/attachments/',
            'img_filename' => 'cautG25EDbHMCEleMcyj1yLt4misHXQAvtG0Q8Pi.jpg',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

    }
}
