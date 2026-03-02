<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),

            // Campos reales de tu BD
            'id_rol'            => null,
            'is_super_admin'    => 0,
            'activo'            => 1, // ya revisamos que lo agregaste
            'permissions'       => null,
        ];
    }

    /** User superadmin */
    public function superAdmin(): static
    {
        return $this->state(fn () => [
            'is_super_admin' => 1,
            'activo'         => 1,
        ]);
    }

    /** Usuario desactivado */
    public function inactivo(): static
    {
        return $this->state(fn () => [
            'activo' => 0,
        ]);
    }

    /** Usuario con rol específico */
    public function withRole($rolId): static
    {
        return $this->state(fn () => [
            'id_rol' => $rolId,
        ]);
    }
}
