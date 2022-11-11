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
        $array1 = array(
            "mate1111",
            "mate2222",
            "mate3333",
            "mate4444",
            "mate5555",
            "mate6666",
            "mate7777",
            "mate8888",
            "mate9999"
        );

        for($i = 0; $i < count($array1); $i++){
            User::create([
                'customer_id' => '1',
                'login_user_id' => $array1[$i],
                'mail' => 'integration-test+' . $array1[$i] . '@mistnet.co.jp',
                'name' => 'mist_' . $array1[$i],
                'initial_password' => bcrypt($array1[$i]),
                'password' => bcrypt($array1[$i]),
                'login_fail_count' => '0',
                'email_verified_at' => null,
                'remember_token' => null,
                'add_account' => '1',
                'upd_account' => '1',
                'del_flg' => '0',
            ]);
        }

        $proper = array(
            "yamaki@mistnet.co.jp",
            "iida_t@mistnet.co.jp",
            "takahashi_sy@mistnet.co.jp",
            "hl_sheng@mistnet.co.jp",
            "saruwatari_e@mistnet.co.jp",
            "t_tanaka@mistnet.co.jp",
            "takeuchi@mistnet.co.jp",
            "nonomiya@mistnet.co.jp",
            "ny_hashimoto@mistnet.co.jp",
            "yano_a@discava.net",
            "hiroki_abe@mistnet.co.jp",
            "m_yasukawa@mistnet.co.jp",
            "r_yoshino@mistnet.co.jp",
            "gaku_ikegami@mistnet.co.jp",
            "dai_toyoda@mistnet.co.jp",
            "iimura@mistnet.co.jp",
            "takao_iida@mistnet.co.jp",
            "kawasaki_t@mistnet.co.jp",
        );

        for($i = 0; $i < count($proper); $i++){
            $pos = strpos($proper[$i], '@') + 1;
            $userid = substr($proper[$i], 0, $pos);
            User::create([
                'customer_id' => '1',
                'login_user_id' => $userid,
                'mail' => $proper[$i],
                'name' => 'mist_' . $userid,
                'initial_password' => bcrypt($userid),
                'password' => bcrypt($userid),
                'login_fail_count' => '0',
                'email_verified_at' => null,
                'remember_token' => null,
                'add_account' => '1',
                'upd_account' => '1',
                'del_flg' => '0',
            ]);
        }

    }
}
