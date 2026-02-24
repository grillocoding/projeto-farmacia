<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::latest()->paginate(10);
        return view('medicamentos.index', compact('medicamentos'));
    }

    public function create()
    {
        return view('medicamentos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'principio_ativo' => 'required|string|max:255',
            'fabricante'      => 'required|string|max:255',
            'categoria'       => 'required|string|max:255',
            'preco'           => 'required|numeric|min:0',
            'estoque'         => 'required|integer|min:0',
            'dosagem'         => 'nullable|string|max:100',
            'requer_receita'  => 'boolean',
            'validade'        => 'nullable|date|after:today',
            'descricao'       => 'nullable|string',
        ]);

        Medicamento::create($validated);

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento cadastrado com sucesso!');
    }

    public function show(Medicamento $medicamento)
    {
        return view('medicamentos.show', compact('medicamento'));
    }

    public function edit(Medicamento $medicamento)
    {
        return view('medicamentos.edit', compact('medicamento'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'principio_ativo' => 'required|string|max:255',
            'fabricante'      => 'required|string|max:255',
            'categoria'       => 'required|string|max:255',
            'preco'           => 'required|numeric|min:0',
            'estoque'         => 'required|integer|min:0',
            'dosagem'         => 'nullable|string|max:100',
            'requer_receita'  => 'boolean',
            'validade'        => 'nullable|date|after:today',
            'descricao'       => 'nullable|string',
        ]);

        $medicamento->update($validated);

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento atualizado com sucesso!');
    }

    public function destroy(Medicamento $medicamento)
    {
        $medicamento->delete(); // softDelete

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento removido com sucesso!');
    }
}