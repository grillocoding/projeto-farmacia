<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Medicamento;

class CarrinhoController extends Controller
{
    // Adiciona o item no carrinho
    public function adicionar(Request $request, Medicamento $medicamento)
    {
        $user = Auth::user();

        // Busca carrinho existente ou cria um novo
        $carrinho = Pedido::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'carrinho'],
            ['total' => 0]
        );

        // Verifica se o medicamento já está no carrinho
        $item = $carrinho->items()->where('medicamento_id', $medicamento->id)->first();

        if ($item) {
            $item->quantidade += 1;
            $item->subtotal = $item->quantidade * $item->preco_unitario;
            $item->save();
        } else {
            $carrinho->items()->create([
                'medicamento_id'  => $medicamento->id,
                'quantidade'      => 1,
                'preco_unitario'  => $medicamento->preco,
                'subtotal'        => $medicamento->preco,
            ]);
        }

        // Atualiza o total do carrinho
        $carrinho->total = $carrinho->items()->sum('subtotal');
        $carrinho->save();

        return back()->with('success', '✅ ' . $medicamento->nome . ' adicionado ao carrinho!');
    }

    // Remover item do carrinho
    public function remover(PedidoItem $item)
    {
        $carrinho = $item->pedido;
        $item->delete();

        $carrinho->total = $carrinho->items()->sum('subtotal');
        $carrinho->save();

        return back()->with('success', 'Item removido do carrinho!');
    }

    // Finalizar compra
    public function finalizar(Request $request)
    {
        $user = Auth::user();
        $carrinho = Pedido::where('user_id', $user->id)
                          ->where('status', 'carrinho')
                          ->first();

        if (!$carrinho || $carrinho->items()->count() === 0) {
            return back()->with('error', 'Seu carrinho está vazio!');
        }

        $carrinho->status = 'pendente';
        $carrinho->endereco_entrega = $request->endereco_entrega;
        $carrinho->save();

        return redirect()->route('medicamentos.index')
                         ->with('success', '🎉 Pedido realizado com sucesso!');
    }
}