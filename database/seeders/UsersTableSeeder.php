<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // システムユーザ(バッチや自動更新用)  users.id=1 のユーザを作成
        User::create([
            'customer_id' => '1',
            'login_user_id' => 'mist_system_admin',
            'mail' => 'info@discava.net',
            'name' => 'administrator',
            'initial_password' => bcrypt('Passw0rd1qazXSW"'),
            'password' => bcrypt('Passw0rd1qazXSW"'),
            'login_fail_count' => '0',
            'email_verified_at' => null,
            'remember_token' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        // 社内検証用ユーザ
        User::create([
            'customer_id' => '1',
            'login_user_id' => 'mist_test001',
            'mail' => 'integration-test+001@mistnet.co.jp',
            'name' => 'mist_test001',
            'initial_password' => bcrypt('Passw0rd'),
            'password' => bcrypt('Passw0rd"'),
            'login_fail_count' => '0',
            'email_verified_at' => null,
            'remember_token' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        
        User::create([
            'customer_id' => '1',
            'login_user_id' => 'mist_test002',
            'mail' => 'integration-test+002@mistnet.co.jp',
            'name' => 'mist_test002',
            'initial_password' => bcrypt('Passw0rd'),
            'password' => bcrypt('Passw0rd"'),
            'login_fail_count' => '0',
            'email_verified_at' => null,
            'remember_token' => null,
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

    }
}
