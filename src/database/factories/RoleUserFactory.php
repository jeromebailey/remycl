<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $userIds;
        if (!isset($userIds)) {
            $userIds = User::whereNotIn('id', [11])->pluck('id')->toArray();
        }

        $userId = array_shift($userIds);
        if (empty($userIds)) {
            $userIds = User::whereNotIn('id', [11])->pluck('id')->toArray();
        }
        return [
            //
            'user_id' => $userId, //User::inRandomOrder()->first()->id,
            'role_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
