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
        $this->call(PlansTableSeeder::class);               // ★初期リリース時に必須
        $this->call(MateFunctionsTableSeeder::class);       // ★初期リリース時に必須
        $this->call(PlanMateFunctionsTableSeeder::class);   // ★初期リリース時に必須
        $this->call(AuthoritySetsTableSeeder::class);       // ★初期リリース時に必須
        $this->call(AuthoritiesTableSeeder::class);         // ★初期リリース時に必須
        //-----------------------------------------------------------------------------
        $this->call(CustomersTableSeeder::class);           // 不要(初期設定は手動登録)
        $this->call(UsersTableSeeder::class);               // 不要(初期設定は手動登録)
        $this->call(ShopsTableSeeder::class);               // 不要(初期設定は手動登録)
        $this->call(ShopUsersTableSeeder::class);           // 不要(初期設定は手動登録)
        $this->call(AnnounceCategoriesTableSeeder::class);  // 不要(手動登録)
        $this->call(AnnouncesTableSeeder::class);           // 不要
        $this->call(AnnounceAttachmentsTableSeeder::class); // 不要
        $this->call(MediaFoldersTableSeeder::class);
        // $this->call(TasksTableSeeder::class);  // 未使用
    }
}
