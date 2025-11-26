<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profesor;

class ProfesorFactory extends Factory
{
    protected $model = Profesor::class;

    public function definition(): array
    {
        $especialidades = Profesor::especialidades();
        $tiposContrato = array_keys(Profesor::tiposContrato());

        // Generar un correo personalizado con el dominio profesor.egm.edu.hn
        $nombre = strtolower($this->faker->firstName());
        $apellido = strtolower($this->faker->lastName());
        $email = "{$nombre}.{$apellido}@profesor.egm.edu.hn";

        return [
            'nombre' => ucfirst($nombre),
            'apellido' => ucfirst($apellido),
            'email' => $email,
            'telefono' => $this->faker->phoneNumber(),
            'dni' => $this->faker->unique()->numerify('#########'),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '1995-01-01'),
            'direccion' => $this->faker->address(),
            'especialidad' => $this->faker->randomElement($especialidades),
            'salario' => $this->faker->randomFloat(2, 8000, 25000),
            'tipo_contrato' => $this->faker->randomElement($tiposContrato),
            'fecha_ingreso' => $this->faker->date('Y-m-d'),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
            'observaciones' => $this->faker->sentence(),
        ];
    }
}
