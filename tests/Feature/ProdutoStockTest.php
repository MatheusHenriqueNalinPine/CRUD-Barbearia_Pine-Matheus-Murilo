<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_barber_can_increase_and_decrease_product_stock(): void
    {
        $barber = User::factory()->create(['role' => 'barbeiro']);
        $product = Produto::create([
            'user_id' => $barber->id,
            'nome' => 'Pomada',
            'preco' => 25.00,
            'quantidade' => 3,
        ]);
        $this->withSession(['user' => ['id' => $barber->id, 'username' => $barber->username]]);

        $productId = Operations::encryptId($product->id);

        $this->from(route('produtos.index'))
            ->post(route('produtos.stock.adjust', ['operacao' => 'aumentar']), [
                'produto_id' => $productId,
            ])
            ->assertRedirect(route('produtos.index'))
            ->assertSessionHas('success');
        $this->assertSame(4, $product->fresh()->quantidade);

        $this->from(route('produtos.index'))
            ->post(route('produtos.stock.adjust', ['operacao' => 'diminuir']), [
                'produto_id' => $productId,
            ])
            ->assertRedirect(route('produtos.index'))
            ->assertSessionHas('success');
        $this->assertSame(3, $product->fresh()->quantidade);
    }

    public function test_stock_adjustment_rejects_non_barbers(): void
    {
        $client = User::factory()->create(['role' => 'cliente']);
        $product = Produto::create([
            'user_id' => $client->id,
            'nome' => 'Pomada',
            'preco' => 25.00,
            'quantidade' => 3,
        ]);
        $this->withSession(['user' => ['id' => $client->id, 'username' => $client->username]]);

        $this->post(route('produtos.stock.adjust', ['operacao' => 'aumentar']), [
            'produto_id' => Operations::encryptId($product->id),
        ])->assertForbidden();

        $this->assertSame(3, $product->fresh()->quantidade);
    }

    public function test_barber_can_adjust_stock_of_seeded_products_owned_by_another_user(): void
    {
        $barber = User::factory()->create(['role' => 'barbeiro']);
        $seedOwner = User::factory()->create(['role' => 'cliente']);
        $seededProduct = Produto::create([
            'user_id' => $seedOwner->id,
            'nome' => 'Pomada do seeder',
            'preco' => 25.00,
            'quantidade' => 12,
        ]);
        $this->withSession(['user' => ['id' => $barber->id, 'username' => $barber->username]]);

        $this->post(route('produtos.stock.adjust', ['operacao' => 'diminuir']), [
            'produto_id' => Operations::encryptId($seededProduct->id),
        ])->assertRedirect();

        $this->assertSame(11, $seededProduct->fresh()->quantidade);
    }
}
