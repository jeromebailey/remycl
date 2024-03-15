<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $email = strtolower($firstName . '.' . $lastName . '@oneivelabs.com');

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email, //preg_replace('/@example\..*/', '@oneivelabs.com', $this->faker->unique()->safeEmail),
            '_uid' => Str::uuid(36),
            'email_verified_at' => now(),
            //'phone_no' => $this->faker->phoneNumber,
            'password' => bcrypt('password'), // '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
