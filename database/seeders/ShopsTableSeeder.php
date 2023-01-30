<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'customer_id' => '1',
            'shop_name' => '本社',
            'plan_id' => '1',
            'postal_code' => '101-0037',
            'address' => '東京都千代田区神田西福田町4丁目2番',
            'building_name' => "D'sVARIE神田ビル（ユニゾ神田西福田町ビル）4F",
            'tel' => '03-3526-7271',
            'fax' => '03-3526-0271',
            'webapi_token' => 'mist1',
            'website_url' => 'https://t-discava.discava-dev.net/displayAnnounceList.php',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        Shop::create([
            'customer_id' => '1',
            'shop_name' => '高松支社',
            'plan_id' => '1',
            'postal_code' => '760-0028',
            'address' => '香川県高松市鍛冶屋町3番地',
            'building_name' => '香川三友ビル3F',
            'tel' => '087-3873-2502',
            'fax' => '087-3873-2503',
            'webapi_token' => bcrypt('mist2'),
            'website_url' => 'https://t-discava.discava-dev.net/displayAnnounceList.php',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

    }
}
