<?php

namespace Tests\Feature;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FornecedorTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_associated_with_its_supplier(): void
    {
        $user = User::factory()->create();
        $this->withSession([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ]);

        $this->post(route('fornecedores.store'), [
            'nome' => 'Fornecedor Pine',
            'email' => 'contato@example.com',
            'telefone' => '11999999999',
            'endereco' => 'Rua Central, 10',
        ])->assertRedirect(route('fornecedores.index'));

        $fornecedor = Fornecedor::firstOrFail();

        $this->get(route('produtos.create'))
            ->assertOk()
            ->assertSee('Fornecedor Pine');

        $this->post(route('produtos.store'), [
            'nome' => 'Pomada',
            'descricao' => 'Pomada modeladora',
            'preco' => 35.90,
            'quantidade' => 5,
            'fornecedor_id' => $fornecedor->id,
        ])->assertRedirect(route('produtos.index'));

        $produto = Produto::firstOrFail();
        $this->assertEquals($fornecedor->id, $produto->fornecedor_id);
        $this->assertSame('Fornecedor Pine', $produto->fornecedor->nome);

        $this->get(route('fornecedores.destroy', [
            'id' => Operations::encryptId($fornecedor->id),
        ]))->assertRedirect(route('fornecedores.index'));

        $this->assertNull($produto->fresh()->fornecedor_id);
        $this->assertSoftDeleted('fornecedores', ['id' => $fornecedor->id]);
    }
}
