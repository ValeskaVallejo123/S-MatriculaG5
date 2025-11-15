<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Estudiante;

class EstudianteFactory extends Factory
{
    protected $model = Estudiante::class;

    public function definition(): array
    {
        // Generar nombre y apellido
        $nombre = strtolower($this->faker->firstName());
        $apellido = strtolower($this->faker->lastName());

        // Crear correo con dominio personalizado
        $email = "{$nombre}.{$apellido}@egm.edu.hn";

        return [
            'nombre' => ucfirst($nombre),
            'apellido' => ucfirst($apellido),
            'email' => $email,
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2005-01-01'),
            'dni' => $this->faker->unique()->numerify('#########'),
            'sexo' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'grado' => $this->faker->randomElement(['1°', '2°', '3°', '4°', '5°', '6°']),
            'seccion' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
        ];
    }
}
