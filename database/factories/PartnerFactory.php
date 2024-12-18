<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'website' => $this->faker->url,
            'email' => $this->faker->unique()->companyEmail,
            'phone_number' => $this->faker->optional()->phoneNumber,
            'type' => 'sponsor',
            'contact_person' => $this->faker->name,
            'deleted_at' => null,
            'logo_path' => $this->faker->optional()->imageUrl(100, 100, 'business', true, 'logo'),
            'status' => 'hidden',
        ];
    }
}
