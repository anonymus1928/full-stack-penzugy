<?php

namespace Database\Factories;

use App\Models\Share;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Share::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $history = [];
        $start = new DateTime('2020-09-26');
        $end = new DateTime('2020-10-24');

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($start, $interval, $end);

        foreach($daterange as $date) {
            $high = $this->faker->randomFloat(4, 10, 5000);
            $low = $this->faker->randomFloat(4, 10, 5000);

            $tmp = $this->faker->randomFloat(4, 10, 5000);
            $open = $tmp >= $low && $tmp <= $high ? $tmp : $low;

            $tmp = $this->faker->randomFloat(4, 10, 5000);
            $close = $tmp >= $low && $tmp <= $high ? $tmp : $high;

            $history[] = [
                'date'  => $date->format("Y-m-d"),
                'high'  => $high,
                'low'   => $low,
                'open'  => $open,
                'close' => $close,
            ];
        }
        $history = array_reverse($history);

        $exchanges = ['NYSE', 'NASDAQ', 'JPX', 'LSE', 'SSE', 'SEHK', 'Euronext', 'TSX', 'SZSE', 'BSE', 'NSE', 'FRA', 'KRX'];

        return [
            'symbol' => $this->faker->unique()->word,
            'name' => $this->faker->company,
            'description' => $this->faker->text,
            'exchange' => $this->faker->randomElement($exchanges),
            'history' => json_encode($history),
        ];
    }
}
