<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Policypayment>
 */
class PolicypaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch a random client
        $client = Client::inRandomOrder()->first();

        // Decide if the payment is a one-time payment
        $isOneTimePayment = $this->faker->boolean;

        // Set amount paid
        $amountPaid = $isOneTimePayment ? $client->policy_amount : $this->faker->numberBetween(50, $client->policy_amount);
        $paid_at = $this->faker->dateTimeBetween($client->policy_start_at, $client->policy_expires_at);
        $next_payment_date = (clone $paid_at)->modify('+1 month');
        
        return [
            '_uid' => Str::uuid(),
            'client_id' => $client->id,
            'amount_paid' => $amountPaid,
            'paid_at' => $paid_at,
            'next_payment_date_at' => $next_payment_date->format('Y-m-d H:i:s')
        ];
    }
}
