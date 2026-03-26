<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable; // 🔥 ADICIONADO

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable; // 🔥 ADICIONADO

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'cpf',
        'phone',
        'foto',
        'adress',
        'cep',
        'bairro',
        'cidade',
        'estado',
        'numero',
        'complemento',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_enabled' => 'boolean',
        'two_factor_expires_at' => 'datetime',
    ];

    // 🔐 GERAR CÓDIGO 2FA
    public function generateTwoFactorCode(): void
    {
        $this->update([
            'two_factor_code' => rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);
    }

    // 🔐 RESETAR 2FA
    public function resetTwoFactorCode(): void
    {
        $this->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);
    }

    // 📦 RELACIONAMENTO PEDIDOS
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    // 👑 VERIFICA ADMIN
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // 👤 VERIFICA CLIENTE
    public function isCliente(): bool
    {
        return $this->role === 'cliente';
    }

  
}