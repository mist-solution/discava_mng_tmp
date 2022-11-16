<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShopUser;

class ShopUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //--------------------------------------
        // システムユーザ
        //--------------------------------------
        ShopUser::create([
            'customer_id' => '1',   // MIST solution
            'shop_id' => '1',       // MIST solution 本社
            'user_id' => '1',       // administrator
            'authority_id' => '1',  // 管理者
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        //--------------------------------------
        // ミスト本社の初期設定
        //--------------------------------------
        ShopUser::create([
            'customer_id' => '1',   // MIST solution
            'shop_id' => '1',       // MIST solution 本社
            'user_id' => '2',       // mist-test001
            'authority_id' => '2',  // 一般
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        ShopUser::create([
            'customer_id' => '1',   // MIST solution
            'shop_id' => '1',       // MIST solution 本社
            'user_id' => '3',       // mist-test002
            'authority_id' => '3',  // 閲覧
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        for($i = 4; i <= 34; i++) {
            ShopUser::create([
                'customer_id' => '1',   // MIST solution
                'shop_id' => '1',       // MIST solution 本社
                'user_id' => $i,
                'authority_id' => '1',  // 管理者
                'add_account' => '1',
                'upd_account' => '1',
                'del_flg' => '0',
            ]);
    
        }

        //--------------------------------------
        // 高松支社の初期設定
        //--------------------------------------
        ShopUser::create([
            'customer_id' => '1',   // MIST solution
            'shop_id' => '2',       // MIST solution 高松支社
            'user_id' => '1',       // administrator
            'authority_id' => '1',  // 管理者
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        ShopUser::create([
            'customer_id' => '1',   // MIST solution
            'shop_id' => '2',       // MIST solution 高松支社
            'user_id' => '2',       // mist-test001
            'authority_id' => '3',  // 閲覧
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

    }
}
