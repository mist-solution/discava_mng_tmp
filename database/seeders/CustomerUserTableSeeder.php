<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CustomerUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = DB::table('customers')->where('code', 'MIST')->first();
        $user = DB::table('users')->where('name', 'mistuser')->first();
        DB::table('customer_user')->insert([
            [
                'customer_id' => $customer->id,
                'user_id' => $user->id,
            ],
        ]);

        $customer = DB::table('customers')->where('code', 'MIST_BRANCH')->first();
        $user = DB::table('users')->where('name', 'takamatsu')->first();
        DB::table('customer_user')->insert([
            [
                'customer_id' => $customer->id,
                'user_id' => $user->id,
            ],
        ]);
    }
}
