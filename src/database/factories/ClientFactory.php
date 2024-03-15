<?php

namespace Database\Factories;

use App\Models\Policytype;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $startRandom = rand(1,12);

        $startDate = $this->faker->dateTimeBetween('-'.$startRandom.' month', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+12 month');

        $policyType = PolicyType::inRandomOrder()->first();

        switch($policyType->slug){
            case 'auto';
            $policyAmount = $this->faker->numberBetween(300, 8000);
            break;

            case 'life';
            $policyAmount = $this->faker->numberBetween(6000, 1000000);
            break;

            case 'health';
            $policyAmount = $this->faker->numberBetween(600, 3000);
            break;

            case 'home';
            $policyAmount = $this->faker->numberBetween(8000, 100000);
            break;
        }

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email_address' => $this->faker->unique()->safeEmail,
            '_uid' => Str::uuid(36),
            'phone_no' => $this->faker->phoneNumber,
            'policy_type_id' => $policyType->id, //Policytype::inRandomOrder()->first()->id,
            'policy_no' => $this->faker->unique()->regexify('GC-[0-9]{7}'),
            'policy_amount' => $policyAmount,
            'policy_start_at' => $startDate,
            'policy_expires_at' => $endDate,
            'active' => rand(0,1)
        ];
    }
}
