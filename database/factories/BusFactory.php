<?php

namespace Database\Factories;

use App\Models\BusModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BusFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'nama' => $this->faker->name(),
           'tipe_bus' => $this->faker->randomElement(['SHD', 'HDD', 'UHD']),
           'photo' => 'bus-images/default.jpeg',
           'jumlah_kursi' => $this->faker->randomElement(['32', '36', '56']),
           'harga' => $this->faker->randomElement([1200000, 1500000, 2000000]),
        ];

    }
}
