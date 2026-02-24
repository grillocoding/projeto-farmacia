<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'status',
        'total',
        'endereco_entrega',
        'observacao',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function medicamentos()
    {
        return $this->hasManyThrough(Medicamento::class, PedidoItem::class);
    }

    public function isPendente(): bool  { return $this->status === 'pendente'; }
    public function isAprovado(): bool  { return $this->status === 'aprovado'; }
    public function isCancelado(): bool { return $this->status === 'cancelado'; }
}