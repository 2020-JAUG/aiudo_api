<?php

namespace Database\Factories;

use App\Models\Cuenta;
use App\Models\Historial_de_pago;
use App\Models\Prestamo;
use Illuminate\Database\Eloquent\Factories\Factory;

class Historial_de_pagoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Historial_de_pago::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fecha_de_pago' => $this->faker->date(),
            'metodo_de_pago' => $this->faker->creditCardType(),
            'status' => $this->faker->boolean(),
            'cuenta_id' => Cuenta::all()->random()->id,//Recoge un id random del modelo cuenta.
            'prestamo_id' => Prestamo::all()->random()->id
        ];
    }
}
