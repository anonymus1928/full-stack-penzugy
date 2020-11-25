<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount'      => $this->faker->randomFloat(4, -1000000, 1000000),
            'name'        => $this->faker->word,
            'description' => $this->faker->text(200),
            'due'         => $this->faker->dateTimeBetween('-5 years', 'now'),
            'user_id'     => $this->faker->numberBetween(1, 3),
        ];
    }
}
