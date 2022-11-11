<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PlansTableSeeder::class);
        $this->call(MateFunctionsTableSeeder::class);
        $this->call(PlanFunctionsTableSeeder::class);
//        $this->call(CustomersTableSeeder::class);
//        $this->call(UsersTableSeeder::class);
//        $this->call(CustomerUserTableSeeder::class);
//        $this->call(AnnounceCategoriesTableSeeder::class);
//        $this->call(AnnouncesTableSeeder::class);
        // $this->call(TasksTableSeeder::class);  // 未使用
    }
}
