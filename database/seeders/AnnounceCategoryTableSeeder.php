<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnounceCategory;

class AnnounceCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AnnounceCategory::create([
            'code' => '',
            'contract_id' => '',
            'category' => '',
            'description' => '',
        ]);
    }
}
