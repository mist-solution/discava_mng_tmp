<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnounceCategory;
use DB;

class AnnounceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->where('name', 'mistuser')->first();
        AnnounceCategory::create([
            'code' => 'TEST',
            'contract_id' => null,
            'category' => 'TEST',
            'description' => null,
            'add_account' => $user->id,
            'upd_account' => $user->id,
        ]);
    }
}
