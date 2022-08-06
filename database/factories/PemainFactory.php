<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemain>
 */
class PemainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nama"  => fake()->name('man'),
            "tinggi_badan" => fake()->numberBetween(150, 200),
            "berat_badan" => fake()->numberBetween(50, 70),
            "posisi" => fake()->randomElement(["penyerang", "gelandang", "bertahan", "penjaga gawang"]),
            "no_punggung" => fake()->numberBetween(1, 99),
        ];
    }
}
