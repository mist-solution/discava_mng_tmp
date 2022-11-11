<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanFunction;

class PlanFunctionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // プラチナプランで対応する機能
        PlanFunction::create([
            'plan_id' => '1',           // プラチナプラン
            'mate_function_id' => '1',  // 投稿管理
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        PlanFunction::create([
            'plan_id' => '1',           // プラチナプラン
            'mate_function_id' => '2',  // ギャラリー管理
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        PlanFunction::create([
            'plan_id' => '1',           // プラチナプラン
            'mate_function_id' => '3',  // アクセス情報
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        PlanFunction::create([
            'plan_id' => '1',           // プラチナプラン
            'mate_function_id' => '4',  // アカウント管理
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        PlanFunction::create([
            'plan_id' => '1',           // プラチナプラン
            'mate_function_id' => '5',  // 契約情報
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        PlanFunction::create([
            'plan_id' => '1',           // プラチナプラン
            'mate_function_id' => '6',  // サイト更新依頼
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
        PlanFunction::create([
            'plan_id' => '1',           // プラチナプラン
            'mate_function_id' => '7',  // WEBサイトへ
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);
    }
}
