<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Corte;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => 'murilo@email.com',
        ], [
            'username' => 'murilo',
            'password' => Hash::make('password'),
        ]);

        if (!$user->cortes()->exists()) {
            $user->cortes()->saveMany(
                Corte::factory(12)->make([
                    'user_id' => $user->id,
                    'imagem' => null,
                ])
            );
        }

        if (!$user->fornecedores()->exists()) {
            $user->fornecedores()->saveMany(
                Fornecedor::factory(12)->make(['user_id' => $user->id])
            );
        }

        if (!$user->produtos()->exists()) {
            $fornecedorIds = $user->fornecedores()->pluck('id')->all();

            $user->produtos()->saveMany(
                Produto::factory(12)
                    ->state(fn () => [
                        'user_id' => $user->id,
                        'fornecedor_id' => fake()->randomElement($fornecedorIds),
                    ])
                    ->make()
            );
        }

        if (!$user->clientes()->exists()) {
            $corteIds = $user->cortes()->pluck('id')->all();

            $user->clientes()->saveMany(
                Cliente::factory(12)
                    ->state(fn () => [
                        'user_id' => $user->id,
                        'corte_favorito_id' => fake()->optional()->randomElement($corteIds),
                    ])
                    ->make()
            );
        }
    }
}