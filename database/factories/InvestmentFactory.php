<?php

namespace Database\Factories;

use App\Models\Investment;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Investment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price'    => $this->faker->randomFloat(4, 10, 5000),
            'amount'   => $this->faker->numberBetween(1, 9999),
            'date'     => $this->faker->dateTimeBetween('-30 years', 'now'),
            'user_id'  => $this->faker->numberBetween(1, 3),
            'share_id' => $this->faker->numberBetween(1,20),
        ];
    }
}
