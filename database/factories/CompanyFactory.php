<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->company(),
            'company_email' => $this->faker->safeEmail(),
            'company_phone' => $this->faker->randomDigitNotNull(),
            'company_address' => $this->faker->address()
        ];
    }
}
