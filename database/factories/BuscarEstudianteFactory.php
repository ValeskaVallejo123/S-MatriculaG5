<?php

namespace Database\Factories;

use App\Models\BuscarEstudiante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BuscarEstudiante>
 */
class BuscarEstudianteFactory extends Factory
{
    protected $model = BuscarEstudiante::class;

    public function definition()
    {
        return [
            'nombre1'           => $this->faker->firstName(),
            'nombre2'           => $this->faker->optional()->firstName(),
            'apellido1'         => $this->faker->lastName(),
            'apellido2'         => $this->faker->optional()->lastName(),
            'dni'               => $this->faker->unique()->numerify('0801######'),
            'fecha_nacimiento'  => $this->faker->date(),
            'nacionalidad'      => 'Hondureña',
            'sexo'              => $this->faker->randomElement(['M', 'F']),
            'direccion'         => $this->faker->address(),
            'telefono'          => $this->faker->optional()->phoneNumber(),
        ];
    }
}
