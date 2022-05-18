<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'mistuser',
            'email' => 'integration-test@mistnet.co.jp',
            'password' => bcrypt('Passw0rd'),
        ]);

        User::create([
            'name' => 'takamatsu',
            'email' => 'integration-test+1@mistnet.co.jp',
            'password' => bcrypt('Passw0rd'),
        ]);
    }
}
