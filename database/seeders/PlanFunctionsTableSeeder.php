<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanFunction;

class PlansTableSeeder extends Seeder
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
            'plan_id' => '1',      // プラチナプラン
            'function_id' => '1',  // 投稿管理
        ]);
        PlanFunction::create([
            'plan_id' => '1',      // プラチナプラン
            'function_id' => '2',  // ギャラリー管理
        ]);
        PlanFunction::create([
            'plan_id' => '1',      // プラチナプラン
            'function_id' => '3',  // アクセス情報
        ]);
        PlanFunction::create([
            'plan_id' => '1',      // プラチナプラン
            'function_id' => '4',  // アカウント管理
        ]);
        PlanFunction::create([
            'plan_id' => '1',      // プラチナプラン
            'function_id' => '5',  // 契約情報
        ]);
        PlanFunction::create([
            'plan_id' => '1',      // プラチナプラン
            'function_id' => '6',  // サイト更新依頼
        ]);
        PlanFunction::create([
            'plan_id' => '1',      // プラチナプラン
            'function_id' => '7',  // WEBサイトへ
        ]);
    }
}
