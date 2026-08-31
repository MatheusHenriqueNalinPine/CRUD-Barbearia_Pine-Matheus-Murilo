<?php

namespace Database\Factories;

use App\Models\Corte;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Corte>
 */
class CorteFactory extends Factory
{
    protected $model = Corte::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nome_corte' => fake()->name(),
            'imagem' => fake()->optional()->imageUrl(640, 480, 'barber'),
            'preco' => fake()->randomFloat(2, 25, 180),
        ];
    }
}