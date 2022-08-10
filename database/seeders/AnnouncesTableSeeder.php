<?php

namespace Database\Seeders;

use App\Models\Announce;
use Illuminate\Database\Seeder;

class AnnouncesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Announce::factory()->count(100)->create();
    }
}
