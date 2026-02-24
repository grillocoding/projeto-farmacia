<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'principio_ativo',
        'fabricante',
        'categoria',
        'preco',
        'estoque',
        'dosagem',
        'requer_receita',
        'validade',
        'descricao',
    ];

    protected $casts = [
        'preco'          => 'decimal:2',
        'requer_receita' => 'boolean',
        'validade'       => 'date',
    ];

    // Um medicamento aparece em muitos itens de pedido
    public function pedidoItems()
    {
        return $this->hasMany(PedidoItem::class);
    }

    // Helper: verifica se tem estoque
    public function emEstoque(): bool
    {
        return $this->estoque > 0;
    }
}