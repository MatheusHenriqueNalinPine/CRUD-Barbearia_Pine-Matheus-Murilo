<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteRoleUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_barber_can_change_only_a_users_role_from_the_clients_tab(): void
    {
        $barber = User::factory()->create(['role' => 'barbeiro']);
        $client = User::factory()->create([
            'role' => 'cliente',
            'username' => 'cliente-original',
            'email' => 'cliente-original@example.com',
        ]);
        $originalPassword = $client->password;
        $this->withSession(['user' => ['id' => $barber->id, 'username' => $barber->username]]);

        $clientId = Operations::encryptId($client->id);

        $this->get(route('clientes.edit', ['id' => $clientId]))
            ->assertOk()
            ->assertSee('name="role"', false)
            ->assertDontSee('name="username"', false)
            ->assertDontSee('name="email"', false)
            ->assertDontSee('name="password"', false);

        $this->post(route('clientes.update', ['id' => $clientId]), [
            'role' => 'barbeiro',
            'username' => 'nome-alterado',
            'email' => 'alterado@example.com',
            'password' => 'senha-alterada',
        ])->assertRedirect(route('clientes.index'))
            ->assertSessionHas('success');

        $client->refresh();
        $this->assertSame('barbeiro', $client->role);
        $this->assertSame('cliente-original', $client->username);
        $this->assertSame('cliente-original@example.com', $client->email);
        $this->assertSame($originalPassword, $client->password);
    }

    public function test_client_cannot_change_a_users_role(): void
    {
        $clientUser = User::factory()->create(['role' => 'cliente']);
        $otherClient = User::factory()->create(['role' => 'cliente']);
        $this->withSession(['user' => ['id' => $clientUser->id, 'username' => $clientUser->username]]);

        $this->post(route('clientes.update', [
            'id' => Operations::encryptId($otherClient->id),
        ]), [
            'role' => 'barbeiro',
        ])->assertForbidden();

        $this->assertSame('cliente', $otherClient->fresh()->role);
    }
}
