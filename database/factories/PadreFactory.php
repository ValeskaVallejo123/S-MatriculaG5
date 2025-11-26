<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PadreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'dni' => fake()->numerify('#########'),
            'parentesco' => fake()->randomElement(['padre', 'madre', 'tutor_legal', 'abuelo', 'abuela', 'tio', 'tia', 'otro']), // ✅ Minúsculas y guión bajo
            'parentesco_otro' => null,
            'correo' => fake()->unique()->safeEmail(),
            'telefono' => fake()->numerify('########'),
            'telefono_secundario' => fake()->optional()->numerify('########'),
            'direccion' => fake()->address(),
            'ocupacion' => fake()->jobTitle(),
            'lugar_trabajo' => fake()->company(),
            'telefono_trabajo' => fake()->optional()->numerify('########'),
            'estado' => 1,
            'observaciones' => null,
        ];
    }
}