<?php

namespace Database\Factories;

use App\Models\CustomerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer_Type>
 */
class CustomerTypeFactory extends Factory
{
    protected $model = CustomerType::class;

    public function definition()
    {
        return [
            'customer_type_name' => $this->faker->unique()->randomElement([
                'Residential',
                'Business',
            ]),
            'customer_value' => $this->faker->randomElement([
                32,
                1200,
            ]),
        ];
    }
}
