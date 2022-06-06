<?php

namespace Database\Seeders;

use App\Models\AnnounceCategory;
use Illuminate\Database\Seeder;

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
