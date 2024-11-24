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
            'logo_path' => $this->faker->optional()->imageUrl(100, 100, 'business', true, 'logo'),
            'dark_logo_path' => $this->faker->optional()->imageUrl(100, 100, 'business', true, 'dark logo'),
            'postcode' => $this->faker->optional()->postcode,
            'street' => $this->faker->optional()->streetName,
            'house_number' => $this->faker->optional()->buildingNumber,
            'city' => $this->faker->optional()->city,
        ];
    }
}
