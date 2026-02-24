<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Medicamento;
use App\Models\PedidoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('user')->latest()->paginate(10);
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $medicamentos = Medicamento::where('estoque', '>', 0)->get();
        $users = \App\Models\User::where('role', 'cliente')->get();
        return view('pedidos.create', compact('medicamentos', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'                => 'required|exists:users,id',
            'endereco_entrega'       => 'nullable|string|max:255',
            'observacao'             => 'nullable|string',
            'items'                  => 'required|array|min:1',
            'items.*.medicamento_id' => 'required|exists:medicamentos,id',
            'items.*.quantidade'     => 'required|integer|min:1',
        ]);

        // Usa transaction para garantir consistência
        DB::transaction(function () use ($request) {
            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $medicamento = Medicamento::findOrFail($item['medicamento_id']);

                // Verifica estoque
                if ($medicamento->estoque < $item['quantidade']) {
                    throw new \Exception("Estoque insuficiente para {$medicamento->nome}");
                }

                $subtotal = $medicamento->preco * $item['quantidade'];
                $total += $subtotal;

                $itemsData[] = [
                    'medicamento_id' => $medicamento->id,
                    'quantidade'     => $item['quantidade'],
                    'preco_unitario' => $medicamento->preco,
                    'subtotal'       => $subtotal,
                ];

                // Decrementa o estoque
                $medicamento->decrement('estoque', $item['quantidade']);
            }

            $pedido = Pedido::create([
                'user_id'          => $request->user_id,
                'status'           => 'pendente',
                'total'            => $total,
                'endereco_entrega' => $request->endereco_entrega,
                'observacao'       => $request->observacao,
            ]);

            $pedido->items()->createMany($itemsData);
        });

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido criado com sucesso!');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('user', 'items.medicamento');
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit', compact('pedido'));
    }

    // No edit só permitimos alterar o status e observações
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'status'           => 'required|in:pendente,aprovado,enviado,entregue,cancelado',
            'endereco_entrega' => 'nullable|string|max:255',
            'observacao'       => 'nullable|string',
        ]);

        // Se cancelar, devolve o estoque
        if ($request->status === 'cancelado' && !$pedido->isCancelado()) {
            DB::transaction(function () use ($pedido, $request) {
                foreach ($pedido->items as $item) {
                    $item->medicamento->increment('estoque', $item->quantidade);
                }
                $pedido->update(['status' => $request->status]);
            });
        } else {
            $pedido->update($request->only('status', 'endereco_entrega', 'observacao'));
        }

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        // Só permite deletar pedidos cancelados
        if (!$pedido->isCancelado()) {
            return redirect()->back()
                ->with('error', 'Só é possível excluir pedidos cancelados.');
        }

        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido removido com sucesso!');
    }
}
