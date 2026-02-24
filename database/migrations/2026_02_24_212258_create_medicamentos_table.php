<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('principio_ativo');
            $table->string('fabricante');
            $table->string('categoria');
            $table->decimal('preco',10,2);
            $table->integer('estoque')->default(0);
            $table->string('dosagem')->nullable();
            $table->boolean('requer_receita')->default(false);
            $table->date('validade')->nullable();
            $table->text('descricao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
