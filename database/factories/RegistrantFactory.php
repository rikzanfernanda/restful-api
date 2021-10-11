<?php

namespace Database\Factories;

use App\Models\Registrant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrantFactory extends Factory
{
    protected $model = Registrant::class;

    public function definition()
    {
        $id_card_number = (string)$this->faker->randomNumber(9, true) . (string)$this->faker->randomNumber(7, true);
        return [
            'name' => $this->faker->name,
            'id_card_number' => $id_card_number,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
