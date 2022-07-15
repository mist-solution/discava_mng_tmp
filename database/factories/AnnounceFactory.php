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
        $announce_category = DB::table('announce_category')->where('id', '1')->first();
        $user = DB::table('users')->where('name', 'mistuser')->first();
        return [
            'title' => 'Announce ' . $this->faker->name(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
            'contents' => $this->faker->text(),
            'announce_category_id' => $announce_category->id,
            'approval_status' => false,
            'approval_comment' => $this->faker->text(),
            'approval_account' => $this->faker->text(),
            'approval_datetime' => $this->faker->dateTime(),
            'remand_comment' => false,
            'del_flg' => false,
            'add_account' => $user->id,
            'upd_account' => $user->id,
        ];
    }
}
