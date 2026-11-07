<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Corte;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_be_created_with_a_favorite_cut_from_the_same_user(): void
    {
        $user = User::factory()->create();
        $this->withSession([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ]);
        $corte = Corte::factory()->create(['user_id' => $user->id]);

        $this->get(route('clientes.create'))
            ->assertOk()
            ->assertSee($corte->nome_corte)
            ->assertSee('Cacheado');

        $this->post(route('clientes.store'), [
            'nome' => 'João Cliente',
            'tipo_cabelo' => 'cacheado',
            'corte_favorito_id' => $corte->id,
        ])->assertRedirect(route('clientes.index'));

        $cliente = Cliente::firstOrFail();
        $this->assertSame($user->id, $cliente->user_id);
        $this->assertEquals($corte->id, $cliente->corte_favorito_id);
        $this->assertSame($corte->nome_corte, $cliente->corteFavorito->nome_corte);
    }

    public function test_client_cannot_select_another_users_cut_as_favorite(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $this->withSession([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ]);
        $otherUsersCut = Corte::factory()->create(['user_id' => $otherUser->id]);

        $this->from(route('clientes.create'))
            ->post(route('clientes.store'), [
                'nome' => 'Cliente Inválido',
                'tipo_cabelo' => 'liso',
                'corte_favorito_id' => $otherUsersCut->id,
            ])
            ->assertSessionHasErrors('corte_favorito_id');

        $this->assertDatabaseCount('clientes', 0);
    }

    public function test_client_list_and_trash_export_as_pdf(): void
    {
        $user = User::factory()->create();
        $this->withSession([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ]);
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);

        $this->get(route('clientes.pdf'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->get(route('clientes.destroy', [
            'id' => Operations::encryptId($cliente->id),
        ]))->assertRedirect(route('clientes.index'));

        $this->get(route('lixeira.clientes.pdf'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }
}
