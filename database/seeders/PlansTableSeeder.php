<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'プラチナプラン',
            'description' => 'DISCaVa MATEを使用するプラン',
        ]);
    }
}
