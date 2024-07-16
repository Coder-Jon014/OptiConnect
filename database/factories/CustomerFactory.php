<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Town;
use App\Models\CustomerType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'customer_name' => $this->faker->name,
            'telephone' => $this->sanitizePhoneNumber($this->faker->phoneNumber),
            'town_id' => function () {
                return \App\Models\town::factory()->create()->town_id;
            },
            'customer_type_id' => function () {
                return \App\Models\CustomerType::factory()->create()->customer_type_id;
            },
        ];
    }

    private function sanitizePhoneNumber($phone)
    {
        return preg_replace('/[^\d]/', '', $phone); // Remove all non-digit characters
    }
}
