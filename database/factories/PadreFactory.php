<?php

namespace Database\Factories;

use App\Models\Padre;
use Illuminate\Database\Eloquent\Factories\Factory;

class PadreFactory extends Factory
{
    protected $model = Padre::class;

    public function definition(): array
    {
        return [
            'nombre'               => $this->faker->firstName(),
            'apellido'             => $this->faker->lastName(),
            'dni'                  => $this->faker->unique()->numerify('#########'),

            // Usar términos consistentes y normalizados
            'parentesco'           => $this->faker->randomElement([
                'padre', 'madre', 'tutor_legal', 'otro'
            ]),

            // Dejar nulo solo si aplica
            'parentesco_otro'      => null,

            'correo'               => $this->faker->unique()->safeEmail(),
            'telefono'             => $this->faker->numerify('########'),
            'telefono_secundario'  => $this->faker->optional()->numerify('########'),

            'direccion'            => $this->faker->address(),

            'observaciones'        => null,
        ];
    }
}
