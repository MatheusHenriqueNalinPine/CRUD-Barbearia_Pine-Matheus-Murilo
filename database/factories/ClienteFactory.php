<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Corte;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cliente>
 */
class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'corte_favorito_id' => null,
            'nome' => fake()->name(),
            'tipo_cabelo' => fake()->randomElement(array_keys(Cliente::TIPOS_CABELO)),
        ];
    }

    public function withCorteFavorito(Corte $corte): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $corte->user_id,
            'corte_favorito_id' => $corte->id,
        ]);
    }
}
