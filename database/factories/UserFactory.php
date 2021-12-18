<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = Arr::random(['Male','Female']);

        $min = $this->faker->numberBetween(0,500000);
        $max = $this->faker->numberBetween($min,500000);



        return [
            'first_name' => $this->faker->firstName($gender),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => 'password', // password
            'dob' => $this->faker->date(),
            'gender' => $gender,
            'annual_income' => $this->faker->randomFloat(),
            'occupation' => Arr::random(['Private Job','Government Job','Business']),
            'family_type' => Arr::random(['Joint Family','Nuclear Family']),
            'manglik' => Arr::random(['Yes','No']),
            'partner_expected_income_min' => $min,
            'partner_expected_income_max' => $max,
            'partner_occupation'  => Arr::random(['Private Job','Government Job','Business'],(rand(1,3))),
            'partner_family_type'  => Arr::random(['Joint Family','Nuclear Family'],(rand(1,2))),
            'partner_manglik'=> Arr::random(['Yes','No']),
            'remember_token' => Str::random(10)
        ];
    }
}
