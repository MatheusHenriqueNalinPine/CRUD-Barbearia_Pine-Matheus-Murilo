<?php

namespace Database\Factories;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produto>
 */
class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'fornecedor_id' => null,
            'nome' => fake()->words(3, true),
            'descricao' => fake()->optional()->sentence(),
            'imagem' => null,
            'preco' => fake()->randomFloat(2, 0, 999999.99),
            'quantidade' => fake()->numberBetween(0, 1000000),
        ];
    }

    public function withFornecedor(Fornecedor $fornecedor): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $fornecedor->user_id,
            'fornecedor_id' => $fornecedor->id,
        ]);
    }
}
