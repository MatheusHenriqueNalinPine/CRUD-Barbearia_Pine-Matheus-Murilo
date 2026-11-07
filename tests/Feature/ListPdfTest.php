<?php

namespace Tests\Feature;

use App\Models\Corte;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_downloads_pdfs_for_products_suppliers_and_trash_lists(): void
    {
        $user = User::factory()->create();
        $this->withSession([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ]);

        $fornecedor = Fornecedor::factory()->create(['user_id' => $user->id]);
        Produto::factory()->withFornecedor($fornecedor)->create();
        Corte::factory()->create(['user_id' => $user->id]);

        $produtoExcluido = Produto::factory()->withFornecedor($fornecedor)->create();
        $produtoExcluido->delete();

        $corteExcluido = Corte::factory()->create(['user_id' => $user->id]);
        $corteExcluido->delete();

        $fornecedorExcluido = Fornecedor::factory()->create(['user_id' => $user->id]);
        $fornecedorExcluido->delete();

        foreach ([
            'produtos.pdf',
            'fornecedores.pdf',
            'lixeira.cortes.pdf',
            'lixeira.produtos.pdf',
            'lixeira.fornecedores.pdf',
        ] as $routeName) {
            $response = $this->get(route($routeName, ['order' => 'oldest']));

            $response->assertOk();
            $response->assertHeader('content-type', 'application/pdf');
            $this->assertStringStartsWith('%PDF-', $response->getContent());
        }
    }
}
