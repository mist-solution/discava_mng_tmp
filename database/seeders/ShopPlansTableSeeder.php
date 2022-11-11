<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShopPlan;

class ShopPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // システムユーザ
        ShopPlan::create([
            'shop_id' => '1',       // MIST solution 本社
            'user_id' => '1',       // administrator
            'authority_id' => '1',  // 管理者
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        ShopPlan::create([
            'shop_id' => '1',       // MIST solution 本社
            'user_id' => '2',       // mist-test001
            'authority_id' => '2',  // 一般
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        ShopPlan::create([
            'shop_id' => '1',       // MIST solution 本社
            'user_id' => '3',       // mist-test002
            'authority_id' => '3',  // 閲覧
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        ShopPlan::create([
            'shop_id' => '2',       // MIST solution 高松支社
            'user_id' => '1',       // administrator
            'authority_id' => '1',  // 管理者
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        ShopPlan::create([
            'shop_id' => '2',       // MIST solution 高松支社
            'user_id' => '2',       // mist-test001
            'authority_id' => '3',  // 閲覧
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

    }
}
