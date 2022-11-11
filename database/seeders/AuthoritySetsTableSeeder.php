<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthoritySet;

class AuthoritySetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //----------------------------------------
        // 管理者
        //----------------------------------------
        AuthoritySet::create([
            'authority_id' => '1',        // 管理者
            'mate_function_id' => '1',    // 投稿管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '1',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '1',        // 管理者
            'mate_function_id' => '2',    // ギャラリー管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '1',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '1',        // 管理者
            'mate_function_id' => '3',    // アクセス情報
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '1',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '1',        // 管理者
            'mate_function_id' => '4',    // アカウント管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '1',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '1',        // 管理者
            'mate_function_id' => '5',    // 契約情報
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '1',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '1',        // 管理者
            'mate_function_id' => '6',    // サイト更新依頼
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '1',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '1',        // 管理者
            'mate_function_id' => '7',    // WEBサイトへ
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '1',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        //----------------------------------------
        // 一般
        //----------------------------------------
        AuthoritySet::create([
            'authority_id' => '2',        // 一般
            'mate_function_id' => '1',    // 投稿管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '1',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '2',        // 一般
            'mate_function_id' => '2',    // ギャラリー管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '1',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '2',        // 一般
            'mate_function_id' => '3',    // アクセス情報
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '1',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '2',        // 一般
            'mate_function_id' => '4',    // アカウント管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '1',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '2',        // 一般
            'mate_function_id' => '5',    // 契約情報
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '1',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '2',        // 一般
            'mate_function_id' => '6',    // サイト更新依頼
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '1',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '2',        // 一般
            'mate_function_id' => '7',    // WEBサイトへ
            'function_auth_flg' => '1',
            'create_auth_flg' => '1',
            'read_auth_flg' => '1',
            'update_auth_flg' => '1',
            'delete_auth_flg' => '1',
            'request_auth_flg' => '1',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        //----------------------------------------
        // 閲覧
        //----------------------------------------
        AuthoritySet::create([
            'authority_id' => '3',        // 閲覧
            'mate_function_id' => '1',    // 投稿管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '0',
            'read_auth_flg' => '1',
            'update_auth_flg' => '0',
            'delete_auth_flg' => '0',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '3',        // 閲覧
            'mate_function_id' => '2',    // ギャラリー管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '0',
            'read_auth_flg' => '1',
            'update_auth_flg' => '0',
            'delete_auth_flg' => '0',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '3',        // 閲覧
            'mate_function_id' => '3',    // アクセス情報
            'function_auth_flg' => '1',
            'create_auth_flg' => '0',
            'read_auth_flg' => '1',
            'update_auth_flg' => '0',
            'delete_auth_flg' => '0',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '3',        // 閲覧
            'mate_function_id' => '4',    // アカウント管理
            'function_auth_flg' => '1',
            'create_auth_flg' => '0',
            'read_auth_flg' => '1',
            'update_auth_flg' => '0',
            'delete_auth_flg' => '0',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '3',        // 閲覧
            'mate_function_id' => '5',    // 契約情報
            'function_auth_flg' => '1',
            'create_auth_flg' => '0',
            'read_auth_flg' => '1',
            'update_auth_flg' => '0',
            'delete_auth_flg' => '0',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '3',        // 閲覧
            'mate_function_id' => '6',    // サイト更新依頼
            'function_auth_flg' => '1',
            'create_auth_flg' => '0',
            'read_auth_flg' => '1',
            'update_auth_flg' => '0',
            'delete_auth_flg' => '0',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        AuthoritySet::create([
            'authority_id' => '3',        // 閲覧
            'mate_function_id' => '7',    // WEBサイトへ
            'function_auth_flg' => '1',
            'create_auth_flg' => '0',
            'read_auth_flg' => '1',
            'update_auth_flg' => '0',
            'delete_auth_flg' => '0',
            'request_auth_flg' => '0',
            'approval_auth_flg' => '0',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
    }
}
