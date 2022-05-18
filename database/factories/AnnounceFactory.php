<?php

namespace Database\Factories;

use App\Models\Announce;
use Illuminate\Database\Eloquent\Factories\Factory;
use DB;

class AnnounceFactory extends Factory
{
    protected $model = Announce::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = DB::table('users')->where('name', 'mistuser')->first();
        return [
            'title' => 'Announce ' . $this->faker->name(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
            'contents' => $this->faker->text(),
            'approval_status' => false,
            'approval_comment' => $this->faker->text(),
            'approval_account' => $this->faker->text(),
            'approval_datetime' => $this->faker->dateTime(),
            'del_flg' => false,
            'add_account' => $user->id,
            'upd_account' => $user->id,
        ];
    }
}
