<?php

namespace Database\Factories;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstudianteFactory extends Factory
{
    protected $model = Estudiante::class;

    public function definition(): array
    {
        return [
            'nombre1'   => $this->faker->firstName(),
            'nombre2'   => $this->faker->optional()->firstName(),
            'apellido1' => $this->faker->lastName(),
            'apellido2' => $this->faker->optional()->lastName(),

            // 13 dígitos
            'dni' => $this->faker->unique()->numerify('#############'),

            'fecha_nacimiento' =>
                $this->faker->dateTimeBetween('-18 years', '-10 years')
                ->format('Y-m-d'),

            'sexo' => $this->faker->randomElement([
                'masculino',
                'femenino'
            ]),

            'grado' => $this->faker->randomElement([
                '1°','2°','3°','4°','5°','6°','7°','8°','9°','10°','11°'
            ]),

            'seccion' => $this->faker->randomElement(['A','B','C']),

            'direccion' => $this->faker->address(),
            'email'     => $this->faker->unique()->safeEmail(),
            'telefono'  => $this->faker->numerify('########'),

            'estado' => 'activo',

            'observaciones' => null,
            'padre_id' => null,
            'foto' => null,
        ];
    }
}