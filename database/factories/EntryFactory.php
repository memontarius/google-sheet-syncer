<?php

namespace Database\Factories;

use App\Models\Enums\EntryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement([EntryStatus::toArray()]),
            'text' => $this->faker->realText(30)
        ];
    }
}
