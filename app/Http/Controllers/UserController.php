<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|unique:users,email',
        'password'    => 'required|string|min:8|confirmed',
        'cpf'         => 'nullable|string|size:14|unique:users,cpf',
        'phone'       => 'nullable|string|max:20',
        'cep'         => 'nullable|string|max:9',
        'address'     => 'nullable|string|max:255',
        'numero'      => 'nullable|string|max:20',
        'complemento' => 'nullable|string|max:100',
        'bairro'      => 'nullable|string|max:100',
        'cidade'      => 'nullable|string|max:100',
        'estado'      => 'nullable|string|size:2',
        'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('users', 'public');
        }
        
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function show(User $user)
    {
        $user->load('pedidos');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => 'required|in:admin,cliente',
            'cpf'      => 'nullable|string|size:14|unique:users,cpf,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

        if ($request->hasFile('foto')) {
        // Remove foto antiga se existir
        if ($user->foto) {
            \Storage::disk('public')->delete($user->foto);
        }
        $validated['foto'] = $request->file('foto')->store('users', 'public');
        }
        
        // Só atualiza a senha se foi enviada
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete(); // softDelete

        return redirect()->route('users.index')
            ->with('success', 'Usuário removido com sucesso!');
    }
}