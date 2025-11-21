<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstudianteFactory extends Factory
{
    public function definition(): array
    {
       return [
            'nombre1' => fake()->firstName(),
            'nombre2' => fake()->firstName(),
            'apellido1' => fake()->lastName(),
            'apellido2' => fake()->lastName(),
            'apellido' => fake()->lastName() . ' ' . fake()->lastName(),
            'dni' => fake()->numerify('#########'),
            'fecha_nacimiento' => fake()->date('Y-m-d', '-10 years'),
            'sexo' => fake()->randomElement(['Masculino', 'Femenino']),
            'grado' => fake()->randomElement(['1°', '2°', '3°', '4°', '5°', '6°']),
            'seccion' => fake()->randomElement(['A', 'B', 'C']),
            'direccion' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->numerify('########'), 
            'estado' => 'activo',
            'observaciones' => null,
            'padre_id' => null,
            'genero' => fake()->randomElement(['Masculino', 'Femenino']),
            'foto' => null,
        ];
    }
}