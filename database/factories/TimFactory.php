<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tim>
 */
class TimFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama' => fake()->name('man'),
            'logo' => fake()->filePath(),
            'tahun' => fake()->date('Y'),
            'alamat' => fake()->text(),
            'kota' => fake()->text(10),
        ];
    }
}
