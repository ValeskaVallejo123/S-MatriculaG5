<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profesor;

class ProfesorFactory extends Factory
{
    protected $model = Profesor::class;

    public function definition(): array
    {
        // Obtener opciones desde el modelo
        $especialidades = Profesor::especialidades();
        $tiposContrato = array_keys(Profesor::tiposContrato());

        // Generar nombres limpios para construir el correo institucional
        $nombre    = strtolower($this->faker->firstName());
        $apellido  = strtolower($this->faker->lastName());

        $email = "{$nombre}.{$apellido}@profesor.egm.edu.hn";

        return [
            'nombre'           => ucfirst($nombre),
            'apellido'         => ucfirst($apellido),
            'email'            => $email,

            'telefono'         => $this->faker->numerify('########'),
            'dni'              => $this->faker->unique()->numerify('#########'),

            // ⚠ Corregido: la fecha que estabas usando es *incorrecta*.
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-60 years', '-25 years')->format('Y-m-d'),

            'direccion'        => $this->faker->address(),
            'especialidad'     => $this->faker->randomElement($especialidades),

            'salario'          => $this->faker->randomFloat(2, 8000, 25000),

            'tipo_contrato'    => $this->faker->randomElement($tiposContrato),
            'fecha_ingreso'    => $this->faker->date('Y-m-d'),

            'observaciones'    => $this->faker->optional()->sentence(),
        ];
    }
}
