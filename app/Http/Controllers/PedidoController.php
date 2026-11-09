<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Services\Operations;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $carrinho = session()->get('carrinho', []);
        return view('carrinho', compact('carrinho'));
    }

    public function adicionar(Request $request, $id)
    {
        $idDecriptografado = Operations::decryptId($id);
        $produto = Produto::findOrFail($idDecriptografado);

        if ($produto->quantidade <= 0) {
            return redirect()->back()->with('error', 'Produto sem estoque.');
        }

        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$idDecriptografado])) {
            if ($carrinho[$idDecriptografado]['quantidade'] >= $produto->quantidade) {
                return redirect()->back()->with('error', 'Quantidade máxima em estoque atingida para este produto.');
            }
            $carrinho[$idDecriptografado]['quantidade']++;
        } else {
            $carrinho[$idDecriptografado] = [
                "nome" => $produto->nome,
                "preco" => $produto->preco,
                "quantidade" => 1,
                "imagem" => $produto->imagem
            ];
        }

        session()->put('carrinho', $carrinho);

        return redirect()->route('produtos.index')->with('success', 'Produto adicionado ao carrinho!');
    }

    public function remover($id)
    {
        $idDecriptografado = Operations::decryptId($id);

        if ($idDecriptografado instanceof \Illuminate\Http\RedirectResponse || !$idDecriptografado) {
            $idDecriptografado = $id; 
        }

        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$idDecriptografado])) {
            unset($carrinho[$idDecriptografado]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('carrinho.index')->with('success', 'Produto removido do carrinho.');
    }

    public function finalizar(Request $request)
    {
        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        // Pega o ID do usuário logado na sessão
        $userId = session('user')['id'] ?? null;

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Faça login para finalizar a compra.');
        }

        try {
            DB::transaction(function () use ($carrinho, $userId) {
                
                $totalGeral = 0;
                foreach ($carrinho as $item) {
                    $totalGeral += $item['preco'] * $item['quantidade'];
                }

                $pedido = Pedido::create([
                    'user_id' => $userId,
                    'total' => $totalGeral,
                    'status' => 'concluido'
                ]);

                foreach ($carrinho as $id => $item) {
                    $produto = Produto::lockForUpdate()->find($id);

                    if (!$produto) {
                        throw new \Exception("O produto '{$item['nome']}' não foi encontrado.");
                    }

                    if ($produto->quantidade < $item['quantidade']) {
                        throw new \Exception("Estoque insuficiente para o produto: {$produto->nome}. Disponível: {$produto->quantidade}.");
                    }

                    $produto->quantidade -= $item['quantidade'];
                    $produto->save();

                    ItemPedido::create([
                        'pedido_id' => $pedido->id,
                        'produto_id' => $id,
                        'quantidade' => $item['quantidade'],
                        'preco_unitario' => $item['preco']
                    ]);
                }
            });

            session()->forget('carrinho');

            return redirect()->route('produtos.index')->with('success', 'Compra finalizada com sucesso! Pedido registrado e estoque atualizado.');

        } catch (\Exception $e) {
            return redirect()->route('carrinho.index')->with('error', $e->getMessage());
        }
    }
}