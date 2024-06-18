<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition()
    {
        return [
            'resource_name' => $this->faker->unique()->randomElement([
                'Bucket-Truck',
                'Splicer',
                'Cable Engineer',
                'Fiber technician',
                'Bucket vane',
            ]),
        ];
    }
}
