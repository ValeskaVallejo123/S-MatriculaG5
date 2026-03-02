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
            'nombre1'           => $this->faker->firstName(),
            'nombre2'           => $this->faker->optional()->firstName(),
            'apellido1'         => $this->faker->lastName(),
            'apellido2'         => $this->faker->optional()->lastName(),
            'dni'               => $this->faker->unique()->numerify('#########'),

            // Fecha entre 10 y 18 años atrás (más realista para estudiantes)
            'fecha_nacimiento'  => $this->faker->dateTimeBetween('-18 years', '-10 years')->format('Y-m-d'),
            'genero'            => $this->faker->randomElement(['Masculino', 'Femenino']),  // ⚠ Campos duplicados pero mantengo estructura por si tu BD lo requiere

            'grado'             => $this->faker->randomElement([
                '1°','2°','3°','4°','5°','6°','7°','8°','9°','10°','11°'
            ]),
            'seccion'           => $this->faker->randomElement(['A','B','C']),

            'direccion'         => $this->faker->address(),
            'email'             => $this->faker->unique()->safeEmail(),
            'telefono'          => $this->faker->numerify('########'),

            'observaciones'     => null,

            // Puedes asignar PadreFactory si quieres que genere relaciones
            'padre_id'          => null,

            'foto'              => null,
        ];
    }
}
