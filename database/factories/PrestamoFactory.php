<?php

namespace Database\Factories;

use App\Models\Cuenta;
use App\Models\Prestamo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrestamoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prestamo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => $this->faker->creditCardType(),
            'deuda_total' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'cantidad_pagada' => $this->faker->numberBetween($min = 400, $max = 500),
            'cuotas' => $this->faker->randomDigitNot(5),
            'fecha_de_inicio' => $this->faker->date(),
            'fecha_de_fin' => $this->faker->date(),
            'cuenta_id' => Cuenta::all()->random()->id//Recoge un id random del modelo cuenta.
        ];
    }
}
